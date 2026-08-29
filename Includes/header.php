<?php
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html><!--This is the HTML5 doctype declaration, which tells our browser to render the page in standards mode.-->
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($page_title) ? htmlspecialchars($page_title) . ' — Xavier Roster' : 'Xavier Roster' ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="brand">
        <span class="brand-mark">X</span> Xavier Roster
    </a>
    <div class="nav-links">
        <a href="index.php">Heroes</a>
        <?php if (is_logged_in()): ?>
            <span class="nav-user">Signed in as <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="nav-btn">Log out</a>
        <?php else: ?>
            <a href="login.php" class="nav-btn">Log in</a>
        <?php endif; ?>
    </div>
</nav>
<main class="page">