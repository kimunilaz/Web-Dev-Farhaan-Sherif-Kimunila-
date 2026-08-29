<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both a username and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // This helps prevent session fixation on privilege change
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Incorrect username or password.';
        }
    }
}

$page_title = 'Log in';
require __DIR__ . '/includes/header.php';
?>


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


<!-- we added this to load the client-side validation which  catches empty fields instantly in the browser, before the form is even sent-->
<script src="js/validate.js"></script>

<!--  This part closes out the shared HTML which are: </main>, the footer bar, and the closing </body></html> tags -->
<?php require __DIR__ . '/includes/footer.php'; 
?>
