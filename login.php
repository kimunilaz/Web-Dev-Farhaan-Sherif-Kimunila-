
<!-- we added this to open the main content area for our log-in form, which is closed in
     includes/footer.php -->
<div class="auth-wrap">
    <div class="auth-card">
        <p class="eyebrow">Staff Access</p>
        <h1>Log in</h1>
        <p class="lede">Only authorized users can access this area. Public visitors can still view the hero roster without signing in.</p>

        <?php if ($error): ?>
            <div class="flash flash-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            
        <?php endif; ?>

 <!-- we added novalidate so that js/validate.js is the only thing showing error messages which keeps our  styling consistent -->
        <form method="post" class="form" novalidate>
           
 <!-- we added this value=".."= to re-fill the username box after a failed login attempt, so the user doesn't have to retype it -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autocomplete="username" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>">
                  
 <!-- There is no value for password as it should never be displayed -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autocomplete="current-password">
                  

            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </form>
    </div>
</div>

