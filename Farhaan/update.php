<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';
require_login(); // only authenticated users may reach this page

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM heroes WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();

if (!$hero) {
    header('Location: index.php');
    exit;
}

$errors = [];

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
        $update = $pdo->prepare(
            'UPDATE heroes SET hero_name=?, real_name=?, short_bio=?, long_bio=?, image_url=?, powers=?, team=?, publisher=?, status=? WHERE id=?'
        );
        $update->execute([$hero_name, $real_name, $short_bio, $long_bio, $image_url, $powers, $team, $publisher, $status, $id]);

        header('Location: hero.php?id=' . $id . '&updated=1');
        exit;
    }

    // Keep submitted values on screen if validation failed
    $hero = array_merge($hero, compact('hero_name', 'real_name', 'short_bio', 'long_bio', 'image_url', 'powers', 'team', 'publisher', 'status'));
}

$page_title = 'Edit ' . $hero['hero_name'];
require __DIR__ . '/includes/header.php';
?>

<a class="back-link" href="hero.php?id=<?= (int)$hero['id'] ?>">&larr; Back to <?= htmlspecialchars($hero['hero_name']) ?></a>

<div class="form-wrap">
    <p class="eyebrow">Update Record</p>
    <h1>Edit <?= htmlspecialchars($hero['hero_name']) ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error">
            <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" class="form" id="hero-form" novalidate>
        <input type="hidden" name="id" value="<?= (int)$hero['id'] ?>">

        <label for="hero_name">Hero name *</label>
        <input type="text" id="hero_name" name="hero_name" required value="<?= htmlspecialchars($hero['hero_name']) ?>">

        <label for="real_name">Real name *</label>
        <input type="text" id="real_name" name="real_name" required value="<?= htmlspecialchars($hero['real_name']) ?>">

        <label for="short_bio">Short biography *</label>
        <input type="text" id="short_bio" name="short_bio" required maxlength="255" value="<?= htmlspecialchars($hero['short_bio']) ?>">

        <label for="long_bio">Long biography *</label>
        <textarea id="long_bio" name="long_bio" required rows="6"><?= htmlspecialchars($hero['long_bio']) ?></textarea>

        <label for="image_url">Image URL</label>
        <input type="url" id="image_url" name="image_url" value="<?= htmlspecialchars($hero['image_url']) ?>">

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

        <button type="submit" class="btn btn-primary btn-block">Save changes</button>
    </form>
</div>

<script src="js/validate.js"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
