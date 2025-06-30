<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'editor'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: ../dashboard.php");
exit();
?>
    