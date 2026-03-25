<?php
declare(strict_types=1);

/**
 * CommerceML2:
 * - import0_1.xml: каталог товаров (Ид, Наименование, Артикул)
 * - offers0_1.xml: цены/остатки (Ид, Цены/Цена/ЦенаЗаЕдиницу, Количество)
 */
function importProducts(PDO $pdo, string $importPath, string $offersPath, int $limit, bool $verbose): array
{
    $created = $updated = $skipped = $errors = 0;

    // 1) соберём цены из offers (external_id => price)
    $prices = [];

    if (is_file($offersPath)) {
        libxml_use_internal_errors(true);
        $xmlOffers = simplexml_load_file($offersPath);
        if ($xmlOffers !== false) {
            $ns = 'urn:1C.ru:commerceml_2';
            $offers = $xmlOffers->children($ns);
            // путь: <ПакетПредложений><Предложения><Предложение>...
            if (isset($offers->ПакетПредложений->Предложения->Предложение)) {
                foreach ($offers->ПакетПредложений->Предложения->Предложение as $offer) {
                    $id = trim((string)($offer->Ид ?? ''));
                    if ($id === '') continue;

                    $price = null;
                    if (isset($offer->Цены->Цена)) {
                        foreach ($offer->Цены->Цена as $p) {
                            $val = (string)($p->ЦенаЗаЕдиницу ?? '');
                            if ($val !== '') {
                                $price = (float)str_replace(',', '.', $val);
                                break;
                            }
                        }
                    }
                    if ($price !== null) {
                        $prices[$id] = $price;
                    }
                }
            }
        }
    }

    // 2) товары из import0_1.xml
    if (!is_file($importPath)) {
        // если нет каталога — не импортируем товары
        return compact('created', 'updated', 'skipped', 'errors');
    }

    libxml_use_internal_errors(true);
    $xml = simplexml_load_file($importPath);
    if ($xml === false) {
        throw new RuntimeException("Failed to parse XML: {$importPath}");
    }

    $ns = 'urn:1C.ru:commerceml_2';
    $root = $xml->children($ns);

    if (!isset($root->Каталог->Товары->Товар)) {
        return compact('created', 'updated', 'skipped', 'errors');
    }

    $count = 0;
    foreach ($root->Каталог->Товары->Товар as $product) {
        $count++;
        if ($limit > 0 && $count > $limit) {
            break;
        }

        try {
            $externalId = trim((string)($product->Ид ?? ''));
            $name = trim((string)($product->Наименование ?? ''));
            if ($externalId === '' || $name === '') {
                $skipped++;
                continue;
            }

            $price = $prices[$externalId] ?? null;

            $stmt = $pdo->prepare("SELECT id FROM products WHERE external_id = ?");
            $stmt->execute([$externalId]);
            $existingId = $stmt->fetchColumn();

            if ($existingId) {
                $upd = $pdo->prepare("
                    UPDATE products
                    SET product_name = :name,
                        price = COALESCE(:price, price)
                    WHERE id = :id
                ");
                $upd->execute([
                    ':name' => $name,
                    ':price' => $price,
                    ':id' => (int)$existingId,
                ]);
                $updated++;
            } else {
                $ins = $pdo->prepare("
                    INSERT INTO products (external_id, product_name, size, price)
                    VALUES (:external_id, :name, NULL, :price)
                ");
                $ins->execute([
                    ':external_id' => $externalId,
                    ':name' => $name,
                    ':price' => $price,
                ]);
                $created++;
            }
        } catch (Throwable $e) {
            $errors++;
            if ($verbose) {
                echo "Product import error: " . $e->getMessage() . PHP_EOL;
            }
        }
    }

    return compact('created', 'updated', 'skipped', 'errors');
}