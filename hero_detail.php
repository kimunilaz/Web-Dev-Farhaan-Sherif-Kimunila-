<?php
require_once __DIR__ . '/config/db.php';//this connects to our database using the configuration file we created in config/db.php
require_once __DIR__ . '/includes/auth.php';//this includes our authentication file to handle user authentication and access control

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);//this retrieves the 'id' parameter from the URL and validates it as an integer. If it's not a valid integer, $id will be false.
if (!$id) {
    header('Location: index.php');//if $id is not valid,it redirects the user to the index page
    exit;
}

// Prepared statement ensures our the id is bound as a parameter and never concatenated
// into the SQL string, so this is safe from SQL injection.

$stmt = $pdo->prepare('SELECT * FROM heroes WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();
//if there are no matching rows (e.g. someone guessed an id that doesn't exist) this sends them back to the roster instead of showing a broken page.
if (!$hero) {
    header('Location: index.php');
    exit;
}

//the page title is set to the hero's name so that it shows up in the browser tab and in the header of the page.
$page_title = $hero['hero_name'];
require __DIR__ . '/includes/header.php';
?>

<a class="back-link" href="index.php">&larr; Back to roster</a>

<div class="hero-detail">
    <div class="hero-detail-image" style="background-image:url('<?= htmlspecialchars($hero['image_url'] ?: 'https://placehold.co/500x500/0f172a/06b6d4?text=' . urlencode($hero['hero_name'])) ?>')"></div>

    <div class="hero-detail-body">
        <span class="hero-card-team"><?= htmlspecialchars($hero['team']) ?> · <?= htmlspecialchars($hero['publisher']) ?></span>
        <h1><?= htmlspecialchars($hero['hero_name']) ?></h1>
        <p class="hero-detail-real">Real name: <?= htmlspecialchars($hero['real_name']) ?></p>

        <dl class="hero-meta">
            <div><dt>Powers</dt><dd><?= htmlspecialchars($hero['powers'] ?: '—') ?></dd></div>
            <div><dt>Status</dt><dd><?= htmlspecialchars($hero['status']) ?></dd></div>
            <div><dt>First appearance</dt><dd><?= $hero['date_created'] ? htmlspecialchars(date('F Y', strtotime($hero['date_created']))) : '—' ?></dd></div>
        </dl>





?>