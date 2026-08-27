
<!-- we added this to open the main content area for our log-in form, which is closed in
     includes/footer.php -->
<div class="auth-wrap">
    <div class="auth-card">
        <p class="eyebrow">Staff Access</p>
        <h1>Log in</h1>
        <p class="lede">Authorized users only. Public visitors can browse the roster without logging in.</p>

        <?php if ($error): ?>
            <div class="flash flash-error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
            
        <?php endif; ?>

 <!-- we added novalidate so that js/validate.js is the only thing showing error messages which keeps our  styling consistent -->
        <form method="post" class="form" novalidate>
           
 <!-- we added this value=".."= to re-fill the username box after a failed login attempt, so the user doesn't have to retype it -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required
                   autocomplete="username"
                   value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>">
                  
 <!-- wThere is no value for password as it should never be displayed -->
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required
                   autocomplete="current-password">
                  

            <button type="submit" class="btn btn-primary btn-block">Log in</button>
        </form>
    </div>
</div>


<!-- we added this to load the client-side validation which  catches empty fields instantly in the browser, before the form is even sent-->
<script src="js/validate.js"></script>

<!--  This part closes out the shared HTML which are: </main>, the
     footer bar, and the closing </body></html> tags -->
<?php require __DIR__ . '/includes/footer.php'; 
?>



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

