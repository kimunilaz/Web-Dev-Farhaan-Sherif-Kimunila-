<?php
session_start();

// __DIR__ makes the path work no matter which folder opens this page.
require_once __DIR__ . '/../xmen-roster/includes/dp_connect.php';

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Please enter your username and password.";
    } else {
        // A prepared statement keeps the username safe in the SQL query.
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                $stmt->close();
                $conn->close();

                header("Location: ../index.php");
                exit;
            }
        }

        // Use the same message for a wrong username or password.
        $error = "Invalid username or password.";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
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
        <h1>Welcome back</h1>
        <p class="intro">Log in to continue to your account.</p>

        <?php if ($error): ?>
            <p class="error-message" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                    autocomplete="username"
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
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit">Log in</button>
        </form>
    </main>
</body>
</html>
