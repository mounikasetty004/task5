<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>Apex Planet Blog</title>

<link rel="stylesheet" href="css/style.css">

</head>
<body>
<nav>
<h1>Apex Planet</h1>
<ul>
<li><a href="#index.php">Home</a></li>
<?php if (isset($_SESSION['user'])): ?>
<li><a href="dashboard.php">Dashboard</a></li>
<li><a href="auth/logout.php">Logout</a></li>
<?php else: ?>
<li><a href="auth/login.php">Login</a></li>
<li><a href="auth/register.php">Register</a></li>
<?php endif; ?>
</ul>
</nav>