<?php
require_once __DIR__ . '/config/db.php';   // we add our database configuration file here so we can connect to our database.
require_once __DIR__ . '/includes/auth.php'; //we add our authentication file here to handle user authentication and access

$stmt = $pdo->query('SELECT id, hero_name, real_name, short_bio, image_url, team FROM heroes ORDER BY hero_name ASC');
$heroes = $stmt->fetchAll();
$page_title = 'All Heroes';
require __DIR__ . '/includes/header.php';
?>
