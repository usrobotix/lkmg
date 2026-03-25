<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    fwrite(STDERR, "Cannot resolve project root.\n");
    exit(1);
}

require_once $root . '/db.php';
require_once $root . '/includes/Logger.php';

$config = require __DIR__ . '/config.php';
$logger = new Logger();

function out(string $msg, bool $verbose = true): void {
    if ($verbose) {
        echo '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
    }
}

$verbose = (bool)($config['verbose'] ?? true);
$xmlDir = rtrim((string)$config['xml_dir'], '/');
$defaultUserId = (int)($config['default_user_id'] ?? 1);

$clientsFile = $xmlDir . '/clients.xml';
$ordersFile  = $xmlDir . '/orders.xml';
$importFile  = $xmlDir . '/import0_1.xml';
$offersFile  = $xmlDir . '/offers0_1.xml';

$outcome = [
    'clients' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0],
    'products' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0],
    'orders' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0],
    'order_items' => ['created' => 0, 'updated' => 0, 'skipped' => 0, 'errors' => 0],
];

try {
    $start = microtime(true);

    out("Import started. xml_dir={$xmlDir}", $verbose);

    if (file_exists($clientsFile)) {
        require_once __DIR__ . '/import_clients.php';
        out("Importing clients.xml ...", $verbose);
        $res = importClients($pdo, $clientsFile, $defaultUserId, (int)($config['limit'] ?? 0), $verbose);
        $outcome['clients'] = $res;
    } else {
        out("clients.xml not found: {$clientsFile}", $verbose);
    }

    if (file_exists($importFile) || file_exists($offersFile)) {
        require_once __DIR__ . '/import_products.php';
        out("Importing products from import0_1.xml + offers0_1.xml ...", $verbose);
        $res = importProducts($pdo, $importFile, $offersFile, (int)($config['limit'] ?? 0), $verbose);
        $outcome['products'] = $res;
    } else {
        out("No product files found (import0_1.xml/offers0_1.xml).", $verbose);
    }

    if (file_exists($ordersFile)) {
        require_once __DIR__ . '/import_orders.php';
        out("Importing orders.xml ...", $verbose);
        $res = importOrders($pdo, $ordersFile, $defaultUserId, (int)($config['limit'] ?? 0), $verbose);
        $outcome['orders'] = $res['orders'];
        $outcome['order_items'] = $res['order_items'];
    } else {
        out("orders.xml not found: {$ordersFile}", $verbose);
    }

    $duration = round(microtime(true) - $start, 3);
    out("Import finished in {$duration}s", $verbose);

    $summary = json_encode($outcome, JSON_UNESCAPED_UNICODE);
    $logger->logAction($pdo, $defaultUserId, 'import_sync_completed', "Summary: {$summary}");

    exit(0);
} catch (Throwable $e) {
    $logger->logAction($pdo, $defaultUserId, 'import_sync_failed', $e->getMessage());
    fwrite(STDERR, $e->getMessage() . "\n");
    exit(1);
}