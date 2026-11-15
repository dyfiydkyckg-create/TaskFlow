<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('روش درخواست مجاز نیست.');
}
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    flash('error', 'شناسه کار معتبر نیست.');
    redirect('index.php');
}
$stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
$stmt->execute(['id' => $id]);
$deleted = $stmt->rowCount() > 0;
flash($deleted ? 'success' : 'error', $deleted ? 'کار حذف شد.' : 'کار موردنظر پیدا نشد.');
redirect('index.php');
