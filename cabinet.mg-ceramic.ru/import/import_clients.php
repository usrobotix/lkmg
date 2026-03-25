<?php
declare(strict_types=1);

function importClients(PDO $pdo, string $filePath, int $defaultUserId, int $limit, bool $verbose): array
{
    $created = $updated = $skipped = $errors = 0;

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($filePath);
    if ($xml === false) {
        throw new RuntimeException("Failed to parse XML: {$filePath}");
    }

    // EnterpriseData: Body в namespace http://v8.1c.ru/edi/edi_stnd/EnterpriseData/1.20
    $body = $xml->children()->Body ?? null;
    if (!$body) {
        // иногда Body лежит как элемент без namespace (зависит от парсинга)
        $body = $xml->Body ?? null;
    }
    if (!$body) {
        throw new RuntimeException("Body not found in {$filePath}");
    }

    $ns = 'http://v8.1c.ru/edi/edi_stnd/EnterpriseData/1.20';
    $bodyChildren = $body->children($ns);

    $count = 0;

    foreach ($bodyChildren as $node) {
        // ожидаем <Справочник.Контрагенты>
        if ($node->getName() !== 'Справочник.Контрагенты') {
            continue;
        }

        $count++;
        if ($limit > 0 && $count > $limit) {
            break;
        }

        try {
            $kp = $node->КлючевыеСвойства ?? null;
            if (!$kp) {
                $skipped++;
                continue;
            }

            $externalId = trim((string)($kp->Ссылка ?? ''));
            $name = trim((string)($kp->Наименование ?? ''));
            $fullName = trim((string)($kp->НаименованиеПолное ?? ''));
            $inn = trim((string)($kp->ИНН ?? ''));
            $kpp = trim((string)($kp->КПП ?? ''));
            $legalType = trim((string)($kp->ЮридическоеФизическоеЛицо ?? ''));

            if ($externalId === '' || $name === '') {
                $skipped++;
                continue;
            }

            if ($legalType !== 'ЮридическоеЛицо' && $legalType !== 'ФизическоеЛицо') {
                $legalType = 'Иное';
            }

            // email/address: на MVP делаем очень простой извлекатель.
            $email = null;
            $address = null;

            if (isset($node->КонтактнаяИнформация)) {
                foreach ($node->КонтактнаяИнформация->Строка as $row) {
                    $kind = trim((string)($row->ВидКонтактнойИнформации ?? ''));
                    $fields = (string)($row->ЗначенияПолей ?? '');

                    if ($kind === 'АдресЭлектроннойПочты') {
                        // в fields обычно лежит XML-строка; попробуем выдернуть email регэкспом
                        if (preg_match('/[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}/iu', $fields, $m)) {
                            $email = $m[0];
                        }
                    }

                    if ($kind === 'ФактическийАдрес' || $kind === 'ЮридическийАдрес') {
                        // просто сохраним как текстовый “сырой” фрагмент (MVP)
                        if ($address === null) {
                            $address = strip_tags(html_entity_decode($fields));
                            $address = trim(preg_replace('/\s+/', ' ', $address));
                        }
                    }
                }
            }

            // upsert по external_id
            $stmt = $pdo->prepare("SELECT id FROM clients WHERE external_id = ?");
            $stmt->execute([$externalId]);
            $existingId = $stmt->fetchColumn();

            if ($existingId) {
                $upd = $pdo->prepare("
                    UPDATE clients
                    SET name = :name,
                        email = :email,
                        address = :address,
                        user_id = COALESCE(user_id, :user_id),
                        inn = :inn,
                        kpp = :kpp,
                        legal_type = :legal_type
                    WHERE id = :id
                ");
                $upd->execute([
                    ':name' => ($fullName !== '' ? $fullName : $name),
                    ':email' => $email,
                    ':address' => $address,
                    ':user_id' => $defaultUserId,
                    ':inn' => ($inn !== '' ? $inn : null),
                    ':kpp' => ($kpp !== '' ? $kpp : null),
                    ':legal_type' => $legalType,
                    ':id' => (int)$existingId,
                ]);
                $updated++;
            } else {
                $ins = $pdo->prepare("
                    INSERT INTO clients (external_id, user_id, name, email, phone, address, status, created_at, inn, kpp, legal_type)
                    VALUES (:external_id, :user_id, :name, :email, NULL, :address, 'active', NOW(), :inn, :kpp, :legal_type)
                ");
                $ins->execute([
                    ':external_id' => $externalId,
                    ':user_id' => $defaultUserId,
                    ':name' => ($fullName !== '' ? $fullName : $name),
                    ':email' => $email,
                    ':address' => $address,
                    ':inn' => ($inn !== '' ? $inn : null),
                    ':kpp' => ($kpp !== '' ? $kpp : null),
                    ':legal_type' => $legalType,
                ]);
                $created++;
            }
        } catch (Throwable $e) {
            $errors++;
            if ($verbose) {
                echo "Client import error: " . $e->getMessage() . PHP_EOL;
            }
        }
    }

    return compact('created', 'updated', 'skipped', 'errors');
}