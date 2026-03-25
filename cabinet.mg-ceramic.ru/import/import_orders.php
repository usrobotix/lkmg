<?php
declare(strict_types=1);

function importOrders(PDO $pdo, string $filePath, int $defaultUserId, int $limit, bool $verbose): array
{
    $ordersCreated = $ordersUpdated = $ordersSkipped = $ordersErrors = 0;
    $itemsCreated = $itemsUpdated = $itemsSkipped = $itemsErrors = 0;

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($filePath);
    if ($xml === false) {
        throw new RuntimeException("Failed to parse XML: {$filePath}");
    }

    $body = $xml->children()->Body ?? null;
    if (!$body) {
        $body = $xml->Body ?? null;
    }
    if (!$body) {
        throw new RuntimeException("Body not found in {$filePath}");
    }

    $ns = 'http://v8.1c.ru/edi/edi_stnd/EnterpriseData/1.20';
    $bodyChildren = $body->children($ns);

    $count = 0;

    foreach ($bodyChildren as $node) {
        if ($node->getName() !== 'Документ.ЗаказКлиента') {
            continue;
        }

        $count++;
        if ($limit > 0 && $count > $limit) break;

        try {
            $kp = $node->КлючевыеСвойства ?? null;
            if (!$kp) {
                $ordersSkipped++;
                continue;
            }

            $externalId = trim((string)($kp->Ссылка ?? ''));
            $externalNumber = trim((string)($kp->Номер ?? ''));
            $dateRaw = trim((string)($kp->Дата ?? ''));
            $totalRaw = trim((string)($node->Сумма ?? ''));

            if ($externalId === '') {
                $ordersSkipped++;
                continue;
            }

            $orderDate = null;
            if ($dateRaw !== '') {
                $orderDate = str_replace('T', ' ', $dateRaw);
            }

            $total = ($totalRaw !== '') ? (float)str_replace(',', '.', $totalRaw) : null;

            // client GUID
            $clientExternalId = trim((string)($node->Контрагент->Ссылка ?? ''));

            $clientId = null;
            if ($clientExternalId !== '') {
                $stmtClient = $pdo->prepare("SELECT id FROM clients WHERE external_id = ?");
                $stmtClient->execute([$clientExternalId]);
                $clientId = $stmtClient->fetchColumn();
            }

            if (!$clientId) {
                $ordersSkipped++;
                continue;
            }

            $stmt = $pdo->prepare("SELECT id FROM orders WHERE external_id = ?");
            $stmt->execute([$externalId]);
            $existingId = $stmt->fetchColumn();

            if ($existingId) {
                $upd = $pdo->prepare("
                    UPDATE orders
                    SET client_id = :client_id,
                        user_id = :user_id,
                        order_date = COALESCE(:order_date, order_date),
                        status = COALESCE(status, 'new'),
                        total = COALESCE(:total, total),
                        external_number = :external_number
                    WHERE id = :id
                ");
                $upd->execute([
                    ':client_id' => (int)$clientId,
                    ':user_id' => $defaultUserId,
                    ':order_date' => $orderDate,
                    ':total' => $total,
                    ':external_number' => ($externalNumber !== '' ? $externalNumber : null),
                    ':id' => (int)$existingId,
                ]);

                $orderId = (int)$existingId;
                $ordersUpdated++;
            } else {
                $ins = $pdo->prepare("
                    INSERT INTO orders (external_id, external_number, client_id, user_id, order_date, status, total)
                    VALUES (:external_id, :external_number, :client_id, :user_id, :order_date, 'new', :total)
                ");
                $ins->execute([
                    ':external_id' => $externalId,
                    ':external_number' => ($externalNumber !== '' ? $externalNumber : null),
                    ':client_id' => (int)$clientId,
                    ':user_id' => $defaultUserId,
                    ':order_date' => $orderDate,
                    ':total' => $total,
                ]);

                $orderId = (int)$pdo->lastInsertId();
                $ordersCreated++;
            }

            // позиции заказа: MVP delete+insert
            $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$orderId]);

            if (isset($node->Товары->Строка)) {
                foreach ($node->Товары->Строка as $row) {
                    try {
                        $nomen = $row->ДанныеНоменклатуры->Номенклатура ?? null;
                        $pName = $nomen ? trim((string)($nomen->Наименование ?? '')) : null;

                        $qtyRaw = trim((string)($row->Количество ?? ''));
                        $priceRaw = trim((string)($row->Цена ?? ''));

                        $qty = ($qtyRaw !== '') ? (float)str_replace(',', '.', $qtyRaw) : 0.0;
                        $price = ($priceRaw !== '') ? (float)str_replace(',', '.', $priceRaw) : null;
                        $lineTotal = ($price !== null) ? $qty * $price : null;

                        $insItem = $pdo->prepare("
                            INSERT INTO order_items (order_id, product_name, quantity, price, total_price)
                            VALUES (:order_id, :product_name, :quantity, :price, :total_price)
                        ");
                        $insItem->execute([
                            ':order_id' => $orderId,
                            ':product_name' => $pName,
                            ':quantity' => $qty, // DECIMAL(10,3)
                            ':price' => $price,
                            ':total_price' => $lineTotal,
                        ]);

                        $itemsCreated++;
                    } catch (Throwable $e) {
                        $itemsErrors++;
                        if ($verbose) echo "Order item import error: " . $e->getMessage() . PHP_EOL;
                    }
                }
            } else {
                $itemsSkipped++;
            }
        } catch (Throwable $e) {
            $ordersErrors++;
            if ($verbose) {
                echo "Order import error: " . $e->getMessage() . PHP_EOL;
            }
        }
    }

    return [
        'orders' => [
            'created' => $ordersCreated,
            'updated' => $ordersUpdated,
            'skipped' => $ordersSkipped,
            'errors' => $ordersErrors,
        ],
        'order_items' => [
            'created' => $itemsCreated,
            'updated' => $itemsUpdated,
            'skipped' => $itemsSkipped,
            'errors' => $itemsErrors,
        ],
    ];
}