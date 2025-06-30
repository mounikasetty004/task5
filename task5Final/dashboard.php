<?php
session_start();
require_once 'includes/db.php';

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Apex Planet</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container">
    <h2 class="heading">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>Your role: <strong><?php echo $user['role']; ?></strong></p>

    <?php if (in_array($user['role'], ['admin', 'editor'])): ?>
        <p><a href="posts/create.php">+ Create New Post</a></p>
    <?php endif; ?>

    <h3>All Blog Posts</h3>
    <div class="post-list">
        <?php
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
        while ($row = $stmt->fetch()) {
            echo "<div class='post'>
                    <h4>" . htmlspecialchars($row['title']) . "</h4>
                    <p>" . htmlspecialchars($row['content']) . "</p>
                    <small>Posted on " . $row['created_at'] . "</small><br>";
            if (in_array($user['role'], ['admin', 'editor'])) {
                echo "<a href='posts/edit.php?id={$row['id']}'>Edit</a> |
                      <a href='posts/delete.php?id={$row['id']}'>Delete</a>";
            }
            echo "</div><br>";
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
