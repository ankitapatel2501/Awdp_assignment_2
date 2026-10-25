<?php
require "../config/db.php"; require "includes/auth.php";
$users=$conn->query("SELECT COUNT(*) c FROM users")->fetch_assoc()['c'];
$cats=$conn->query("SELECT COUNT(*) c FROM categories")->fetch_assoc()['c'];
$products=$conn->query("SELECT COUNT(*) c FROM products")->fetch_assoc()['c'];
$orders=$conn->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()['c'];
$sales=$conn->query("SELECT COALESCE(SUM(total_amount),0) s FROM orders WHERE payment_status='Paid' OR order_status!='Cancelled'")->fetch_assoc()['s'];
require "includes/header.php";
?>
<h1>Dashboard</h1><div class="cards">
<div class="stat"><h3>Total Users</h3><h2><?php echo $users;?></h2></div>
<div class="stat"><h3>Total Categories</h3><h2><?php echo $cats;?></h2></div>
<div class="stat"><h3>Total Products</h3><h2><?php echo $products;?></h2></div>
<div class="stat"><h3>Total Orders</h3><h2><?php echo $orders;?></h2></div>
<div class="stat"><h3>Total Sales</h3><h2>₹<?php echo number_format($sales,2);?></h2></div>
</div>
<?php require "includes/footer.php"; ?>