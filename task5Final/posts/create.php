<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'editor'])) {
    header("Location: ../auth/login.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header("Location: ../dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post - Apex Planet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2 class="heading">Create New Post</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" required></textarea><br><br>
        <button type="submit">Post</button>
    </form>
</div>
</body>
</html>
