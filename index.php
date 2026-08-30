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

<!--this block checks for the deleted query param and shows a one-time success message after a redirect-->
<?php if (isset($_GET['deleted'])): ?>
    <!-- we show this success flash message here to confirm that the hero record has been deleted successfully -->
    <div class="flash flash-success">Hero record deleted.</div>
<?php endif; ?>

<!--this block opens the grid container and starts the loop, wrapping each hero in a clickable card link -->
<div class="hero-grid">
    <?php foreach ($heroes as $hero): ?>
        <a class="hero-card" href="hero.php?id=<?= (int)$hero['id'] ?>"> <!-- we cast the id to int here as a precaution safety net against injection since it's going straight into the URL -->
            <div class="hero-card-image" style="background-image:url('<?= htmlspecialchars($hero['image_url'] ?: 'https://placehold.co/300x300/0f172a/06b6d4?text=' . urlencode($hero['hero_name'])) ?>')"></div> <!-- this block renders the hero's image as a background, falling back to a generated placeholder -->
            <!-- we go back to a placeholder image here if the hero doesn't have any set, and we use their name as placeholder text -->
            <div class="hero-card-body">
                <span class="hero-card-team"><?= htmlspecialchars($hero['team']) ?></span>
                <h2><?= htmlspecialchars($hero['hero_name']) ?></h2>
                <p class="hero-card-real"><?= htmlspecialchars($hero['real_name']) ?></p>
                <p class="hero-card-bio"><?= htmlspecialchars($hero['short_bio']) ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>
<!-- this  handles a situation where the heroes table is empty and closes out the grid container -->
 <?php if (empty($heroes)): ?>
        <p class="empty-state">No heroes on file yet.</p>
    <?php endif; ?>


<?php require __DIR__ . '/includes/footer.php'; ?><!-- we bring in our shared footer include here to close out the page  -->