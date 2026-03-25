<?php
require_once '../includes/security.php';
require_once '../db.php';
require_once '../functions.php';

// Форматирование статуса
function webOrderStatusLabel(?string $status): string {
    return match ($status) {
        'new' => 'Новый',
        'processed' => 'Обработан',
        default => (string)($status ?? ''),
    };
}

function webOrderStatusBadgeClass(?string $status): string {
    return match ($status) {
        'new' => 'status status--new',
        'processed' => 'status status--completed',
        default => 'status',
    };
}

function formatDt(?string $v): string {
    if (!$v) return '';
    $ts = strtotime((string)$v);
    if (!$ts) return (string)$v;
    return date('d.m.Y H:i', $ts);
}

// Фильтр по статусу (опционально)
$status = $_GET['status'] ?? '';

$query = "
    SELECT id, created_at, customer_name, phone, email, city, status, total
    FROM web_orders
    WHERE 1=1
";
$params = [];

if ($status) {
    $query .= " AND status = ?";
    $params[] = $status;
}

$query .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$webOrders = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<h2>Заказы с сайта</h2>

<form method="get" action="" class="filters">
    <select name="status">
        <option value="">Все статусы</option>
        <option value="new" <?= $status === 'new' ? 'selected' : '' ?>>Новый</option>
        <option value="processed" <?= $status === 'processed' ? 'selected' : '' ?>>Обработан</option>
    </select>
    <button type="submit">Фильтровать</button>
</form>

<div class="table-wrap">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Клиент</th>
            <th>Телефон</th>
            <th>Email</th>
            <th>Город</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($webOrders)): ?>
            <tr>
                <td colspan="9" class="muted">Ничего не найдено.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($webOrders as $order): ?>
                <tr>
                    <td><?= h($order['id']) ?></td>
                    <td><?= h(formatDt($order['created_at'] ?? '')) ?></td>
                    <td><?= h($order['customer_name']) ?></td>
                    <td><?= h($order['phone']) ?></td>
                    <td><?= h($order['email']) ?></td>
                    <td><?= h($order['city']) ?></td>
                    <td><?= isset($order['total']) ? number_format((float)$order['total'], 2, ',', ' ') . ' ₽' : '' ?></td>
                    <td>
                        <span class="<?=h(webOrderStatusBadgeClass($order['status'] ?? null)) ?>">
                            <?=h(webOrderStatusLabel($order['status'] ?? null)) ?>
                        </span>
                    </td>
                    <td>
                        <a href="/pages/web_order_detail.php?id=<?= (int)$order['id'] ?>">Открыть</a>
                        <?php if (($order['status'] ?? '') !== 'processed'): ?>
                            |
                            <form action="/pages/web_order_process.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int)$order['id'] ?>">
                                <input type="hidden" name="csrf_token" value="<?= h(csrf_token()) ?>">
                                <button type="submit" class="link-button">Отметить как обработан</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>