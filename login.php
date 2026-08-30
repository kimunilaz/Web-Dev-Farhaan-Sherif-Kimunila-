<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth.php';

redirect_if_logged_in();

$registration_mode = $registration_mode ?? false;
$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($registration_mode) {
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        if ($username === '' || $password === '' || $password_confirmation === '') {
            $error = 'Please complete all fields.';
        } elseif (strlen($username) < 3 || strlen($username) > 50) {
            $error = 'Username must be between 3 and 50 characters.';
        } elseif (!preg_match('/^[A-Za-z0-9_.-]+$/', $username)) {
            $error = 'Username may contain letters, numbers, dots, underscores, and hyphens only.';
        } elseif (strlen($password) < 8) {
            $error = 'Password must contain at least 8 characters.';
        } elseif ($password !== $password_confirmation) {
            $error = 'Passwords do not match.';
        } else {
            $check = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $check->execute([$username]);

            if ($check->fetch()) {
                $error = 'That username is already registered.';
            } else {
                try {
                    $insert = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                    $insert->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);

                    login_user([
                        'id' => $pdo->lastInsertId(),
                        'username' => $username,
                    ]);

                    header('Location: ' . app_url('index.php'));
                    exit;
                } catch (PDOException $exception) {
                    if ($exception->getCode() === '23000') {
                        $error = 'That username is already registered.';
                    } else {
                        throw $exception;
                    }
                }
            }
        }
    } elseif ($username === '' || $password === '') {
        $error = 'Please enter your username and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
                $rehash = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $rehash->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
            }

            login_user($user);
            header('Location: ' . app_url('index.php'));
            exit;
        }

        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $registration_mode ? 'Register' : 'Log in' ?></title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
            color: #242424;
            background: #f4f3ef;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background: #f4f3ef;
        }

        .login-card {
            width: min(100%, 400px);
            padding: 36px;
            background: #ffffff;
            border: 1px solid #deddd8;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(30, 30, 30, 0.07);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 1.75rem;
            line-height: 1.2;
        }

        .intro {
            margin: 0 0 28px;
            color: #656565;
            line-height: 1.5;
        }

        .error-message {
            margin: 0 0 20px;
            padding: 12px 14px;
            color: #8b2525;
            background: #fff2f2;
            border: 1px solid #e7bcbc;
            border-radius: 5px;
            font-size: 0.92rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.92rem;
            font-weight: 600;
        }

        input {
            width: 100%;
            height: 44px;
            padding: 10px 12px;
            color: #242424;
            background: #ffffff;
            border: 1px solid #bcbcb7;
            border-radius: 5px;
            font: inherit;
        }

        input:hover {
            border-color: #8d8d88;
        }

        input:focus {
            border-color: #315f4c;
            outline: 3px solid rgba(49, 95, 76, 0.16);
        }

        button {
            width: 100%;
            min-height: 44px;
            padding: 10px 16px;
            color: #ffffff;
            background: #315f4c;
            border: 1px solid #315f4c;
            border-radius: 5px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #274d3e;
            border-color: #274d3e;
        }

        button:focus-visible {
            outline: 3px solid rgba(49, 95, 76, 0.25);
            outline-offset: 2px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .login-card {
                padding: 28px 22px;
            }
        }
    </style>
</head>
<body>
    <main class="login-card">
        <h1><?= $registration_mode ? 'Create an account' : 'Welcome back' ?></h1>
        <p class="intro"><?= $registration_mode ? 'Register to manage the Xavier roster.' : 'Log in to continue to your account.' ?></p>

        <?php if ($error): ?>
            <p class="error-message" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="" data-validate="auth">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                    autocomplete="username"
                    maxlength="50"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="<?= $registration_mode ? 'new-password' : 'current-password' ?>"
                    required
                >
            </div>

            <?php if ($registration_mode): ?>
                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required
                    >
                </div>
            <?php endif; ?>

            <button type="submit"><?= $registration_mode ? 'Register' : 'Log in' ?></button>
        </form>

        <p class="intro">
            <?php if ($registration_mode): ?>
                Already registered? <a href="<?= htmlspecialchars(app_url('login.php')) ?>">Log in</a>.
            <?php else: ?>
                Need an account? <a href="<?= htmlspecialchars(app_url('register.php')) ?>">Register</a>.
            <?php endif; ?>
            <a href="<?= htmlspecialchars(app_url('index.php')) ?>">Back to roster</a>.
        </p>
    </main>
    <script src="<?= htmlspecialchars(app_url('assets/js/validate.js')) ?>"></script>
</body>
</html>
