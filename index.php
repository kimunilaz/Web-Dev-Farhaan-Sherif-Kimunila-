<?php
require_once __DIR__ . '/config/db.php';   // we add our database configuration file here so we can connect to our database.
require_once __DIR__ . '/includes/auth.php'; //we add our authentication file here to handle user authentication and access

//we fetch the hero details we need from our heroes table and arrange them in alphabetic order by hero_name. We then store the results in the $heroes variable.
$stmt = $pdo->query('SELECT id, hero_name, real_name, short_bio, image_url, team FROM heroes ORDER BY hero_name ASC');
$heroes = $stmt->fetchAll();
$page_title = 'All Heroes';
require __DIR__ . '/includes/header.php';
?>

<!--we create the page heading section to introduce our heroes roster-->
<div class="page-head">
    <div>
        <p class="eyebrow">Professor Xavier's Records</p> <!-- we add a small eyebrow label here to give the page some Xavier-flavored context -->
        <h1>Team Roster</h1>
        <p class="lede">Every mutant currently on file. Log in to update or remove a record.</p>
    </div>
</div>