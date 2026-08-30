<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login(); // only authenticated users may delete

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . app_url('index.php'));
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: ' . app_url('index.php') . '?delete_error=1');
    exit;
}

$stmt = $pdo->prepare('DELETE FROM heroes WHERE id = ?');
$stmt->execute([$id]);

$result = $stmt->rowCount() === 1 ? 'deleted=1' : 'delete_error=1';
header('Location: ' . app_url('index.php') . '?' . $result);
exit;
