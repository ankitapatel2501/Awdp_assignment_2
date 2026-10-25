<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mitti & Makers</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="navbar">
  <div class="container nav-inner">
    <a class="logo" href="index.php">Mitti & Makers</a>
    <nav>
      <a href="index.php">Home</a>
      <a href="categories.php">Categories</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="cart.php">Cart (<?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>)</a>
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="orders.php">Orders</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">