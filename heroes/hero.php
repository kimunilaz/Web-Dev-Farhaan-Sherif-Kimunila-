<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: ' . app_url('index.php'));
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM heroes WHERE id = ?');
$stmt->execute([$id]);
$hero = $stmt->fetch();

if (!$hero) {
    header('Location: ' . app_url('index.php'));
    exit;
}

$page_title = $hero['hero_name'];
require __DIR__ . '/../includes/header.php';
?>

<a class="back-link" href="<?= htmlspecialchars(app_url('index.php')) ?>">&larr; Back to roster</a>

<?php if (isset($_GET['created'])): ?>
    <div class="flash flash-success">Hero created.</div>
<?php elseif (isset($_GET['updated'])): ?>
    <div class="flash flash-success">Hero updated.</div>
<?php endif; ?>

<div class="hero-detail">
    <div class="hero-detail-image" style="background-image:url('<?= htmlspecialchars(hero_image_url($hero['image_url'], $hero['hero_name'])) ?>')"></div>

    <div class="hero-detail-body">
        <span class="hero-card-team"><?= htmlspecialchars($hero['team']) ?> · <?= htmlspecialchars($hero['publisher']) ?></span>
        <h1><?= htmlspecialchars($hero['hero_name']) ?></h1>
        <p class="hero-detail-real">Real name: <?= htmlspecialchars($hero['real_name']) ?></p>

        <dl class="hero-meta">
            <div><dt>Powers</dt><dd><?= htmlspecialchars($hero['powers'] ?: '—') ?></dd></div>
            <div><dt>Status</dt><dd><?= htmlspecialchars($hero['status']) ?></dd></div>
            <div><dt>First appearance</dt><dd><?= $hero['date_created'] ? htmlspecialchars(date('F Y', strtotime($hero['date_created']))) : '—' ?></dd></div>
        </dl>

        <h3>Biography</h3>
        <p class="hero-detail-bio"><?= nl2br(htmlspecialchars($hero['long_bio'])) ?></p>

        <?php if (is_logged_in()): ?>
            <div class="detail-actions">
                <a class="btn btn-primary" href="<?= htmlspecialchars(app_url('heroes/update.php')) ?>?id=<?= (int)$hero['id'] ?>">Update record</a>
                <form action="<?= htmlspecialchars(app_url('heroes/delete.php')) ?>" method="post" onsubmit="return confirm('Delete this hero permanently? This cannot be undone.');">
                    <input type="hidden" name="id" value="<?= (int)$hero['id'] ?>">
                    <button type="submit" class="btn btn-danger">Delete record</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
