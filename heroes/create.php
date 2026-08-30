<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login(); // only authenticated users may create a new hero

$errors = [];

// Defaults for a blank form (used both on first load and if validation fails)
$hero = [
    'hero_name' => '', 'real_name' => '', 'short_bio' => '', 'long_bio' => '',
    'image_url' => '', 'powers' => '', 'team' => 'X-Men', 'publisher' => 'Marvel Comics', 'status' => 'Active',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hero_name = trim($_POST['hero_name'] ?? '');
    $real_name = trim($_POST['real_name'] ?? '');
    $short_bio = trim($_POST['short_bio'] ?? '');
    $long_bio  = trim($_POST['long_bio'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $powers    = trim($_POST['powers'] ?? '');
    $team      = trim($_POST['team'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $status    = trim($_POST['status'] ?? '');

    if ($hero_name === '') $errors[] = 'Hero name is required.';
    if ($real_name === '') $errors[] = 'Real name is required.';
    if ($short_bio === '') $errors[] = 'Short biography is required.';
    if ($long_bio === '')  $errors[] = 'Long biography is required.';

    if (empty($errors)) {
        $insert = $pdo->prepare(
            'INSERT INTO heroes (hero_name, real_name, short_bio, long_bio, image_url, powers, team, publisher, status, date_created)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())'
        );
        $insert->execute([$hero_name, $real_name, $short_bio, $long_bio, $image_url, $powers, $team, $publisher, $status]);

        $new_id = $pdo->lastInsertId();
        header('Location: ' . app_url('heroes/hero.php') . '?id=' . $new_id . '&created=1');
        exit;
    }

    // Keep submitted values on screen if validation failed
    $hero = compact('hero_name', 'real_name', 'short_bio', 'long_bio', 'image_url', 'powers', 'team', 'publisher', 'status');
}

$page_title = 'Add a new hero';
require __DIR__ . '/../includes/header.php';
?>

<a class="back-link" href="<?= htmlspecialchars(app_url('index.php')) ?>">&larr; Back to roster</a>

<div class="form-wrap">
    <p class="eyebrow">New Record</p>
    <h1>Add a new hero</h1>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error">
            <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" class="form" id="hero-form" novalidate>
        <label for="hero_name">Hero name *</label>
        <input type="text" id="hero_name" name="hero_name" required value="<?= htmlspecialchars($hero['hero_name']) ?>">

        <label for="real_name">Real name *</label>
        <input type="text" id="real_name" name="real_name" required value="<?= htmlspecialchars($hero['real_name']) ?>">

        <label for="short_bio">Short biography *</label>
        <input type="text" id="short_bio" name="short_bio" required maxlength="255" value="<?= htmlspecialchars($hero['short_bio']) ?>">

        <label for="long_bio">Long biography *</label>
        <textarea id="long_bio" name="long_bio" required rows="6"><?= htmlspecialchars($hero['long_bio']) ?></textarea>

        <label for="image_url">Image URL</label>
        <input type="url" id="image_url" name="image_url" placeholder="images/your-file.jpeg" value="<?= htmlspecialchars($hero['image_url']) ?>">

        <label for="powers">Powers</label>
        <input type="text" id="powers" name="powers" value="<?= htmlspecialchars($hero['powers']) ?>">

        <div class="form-row">
            <div>
                <label for="team">Team</label>
                <input type="text" id="team" name="team" value="<?= htmlspecialchars($hero['team']) ?>">
            </div>
            <div>
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher" value="<?= htmlspecialchars($hero['publisher']) ?>">
            </div>
            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <?php foreach (['Active', 'Inactive', 'Deceased', 'Unknown'] as $opt): ?>
                        <option value="<?= $opt ?>" <?= $hero['status'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Create hero</button>
    </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
