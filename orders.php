<?php
require "config/db.php"; require "includes/auth.php";
$uid=$_SESSION['user_id'];
$result=$conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY id DESC");
require "includes/header.php";
?>
<h1>Order History</h1>
<table><tr><th>Order ID</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Details</th></tr>
<?php while($o=$result->fetch_assoc()): ?>
<tr><td>#<?php echo $o['id']; ?></td><td><?php echo $o['order_date']; ?></td><td>₹<?php echo number_format($o['total_amount'],2); ?></td><td><?php echo htmlspecialchars($o['payment_method']); ?></td><td><?php echo htmlspecialchars($o['order_status']); ?></td><td><a href="order-details.php?id=<?php echo $o['id']; ?>">View</a></td></tr>
<?php endwhile; ?></table>
<?php require "includes/footer.php"; ?>