<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'editor'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found.");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        header("Location: ../dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post - Apex Planet</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2 class="heading">Edit Post</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>
        <label>Content:</label><br>
        <textarea name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>
        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
