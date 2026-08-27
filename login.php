//d3hgd
<div class="auth-wrap">
    <div class="auth-card">
        <p class="eyebrow">Staff-only Access</p>
        <h1>Log in</h1>
        <p class="lede">Authorized users only. Public visitors can browse the roster without logging in.</p>

        <?php if ($error): ?>
            <div class="flash flash-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="form" novalidate>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autocomplete="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">

            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </form>

        <p class="hint">Demo credentials — username: <code>admin</code>, password: <code>password123</code></p>
    </div>
</div>

<script src="js/validate.js"></script>