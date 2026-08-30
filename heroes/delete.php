<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
require_login(); // only authenticated users may delete

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        $stmt = $pdo->prepare('DELETE FROM heroes WHERE id = ?');
        $stmt->execute([$id]);
    }
}

header('Location: index.php?deleted=1');
exit;
