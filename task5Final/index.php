<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<div class="container">
<h2 class="heading">Latest Blog Posts</h2>
<div class="post-list">
<?php
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
while ($row = $stmt->fetch()) {
echo "<div class='post'>
<h3>{$row['title']}</h3>
<p>{$row['content']}</p>
<small>Posted on {$row['created_at']}</small>
</div>";
}
?>
</div>
</div>
<?php include 'includes/footer.php'; ?>