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
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input
            type="text"
            id="username"
            name="username"
            value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
            autocomplete="username"
            required
        ><br>

        <label for="password">Password:</label>
        <input
            type="password"
            id="password"
            name="password"
            autocomplete="current-password"
            required
        ><br>

        <button type="submit">Log In</button>
    </form>
</body>
</html>
