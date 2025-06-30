<?php
session_start();
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check for duplicate username
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $error = "Username already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role = 'editor'; // default role

            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $role]);

            $success = "Registration successful. Redirecting to login...";
            header("refresh:2;url=login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Apex Planet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2 class="heading">Register</h2>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirm Password:</label><br>
        <input type="password" name="confirm" required><br><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</div>
</body>
</html>
