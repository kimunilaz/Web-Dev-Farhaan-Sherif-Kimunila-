<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — Xavier Roster' : 'Xavier Roster' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars(app_url('assets/css/style.css')) ?>">
</head>
<body>
<nav class="navbar">
    <a href="<?= htmlspecialchars(app_url('index.php')) ?>" class="brand">
        <span class="brand-mark">X</span> Xavier Roster
    </a>
    <div class="nav-links">
        <a href="<?= htmlspecialchars(app_url('index.php')) ?>">Heroes</a>
        <?php if (is_logged_in()): ?>
            <a href="<?= htmlspecialchars(app_url('heroes/create.php')) ?>">Add hero</a>
            <span class="nav-user">Signed in as <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
            <a href="<?= htmlspecialchars(app_url('logout.php')) ?>" class="nav-btn">Log out</a>
        <?php else: ?>
            <a href="<?= htmlspecialchars(app_url('register.php')) ?>">Register</a>
            <a href="<?= htmlspecialchars(app_url('login.php')) ?>" class="nav-btn">Log in</a>
        <?php endif; ?>
    </div>
</nav>
<main class="page">
