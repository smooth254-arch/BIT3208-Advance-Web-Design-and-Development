<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manage_products.php');
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    header('Location: manage_products.php');
    exit;
}

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}
header('Location: manage_products.php');
exit;
?>
