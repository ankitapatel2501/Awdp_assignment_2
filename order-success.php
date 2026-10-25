<?php
require "config/db.php"; require "includes/auth.php";
$id=(int)($_GET['id'] ?? 0);
$stmt=$conn->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");
$stmt->bind_param("ii",$id,$_SESSION['user_id']); $stmt->execute(); $order=$stmt->get_result()->fetch_assoc();
if(!$order) die("Order not found.");
$items=$conn->query("SELECT oi.*,p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$id");
require "includes/header.php";
?>
<div class="success"><h1>Order Placed Successfully!</h1>
<p>Order ID: #<?php echo $order['id']; ?></p>
<p>Date: <?php echo $order['order_date']; ?></p>
<p>Customer: <?php echo htmlspecialchars($order['customer_name']); ?></p>
<p>Total: ₹<?php echo number_format($order['total_amount'],2); ?></p>
<p>Payment: <?php echo htmlspecialchars($order['payment_method']); ?></p></div>
<h2>Ordered Products</h2>
<table><tr><th>Product</th><th>Qty</th><th>Price</th></tr>
<?php while($i=$items->fetch_assoc()): ?><tr><td><?php echo htmlspecialchars($i['name']); ?></td><td><?php echo $i['quantity']; ?></td><td>₹<?php echo number_format($i['price'],2); ?></td></tr><?php endwhile; ?>
</table>
<a class="btn" href="products.php">Continue Shopping</a> <a class="btn" href="orders.php">Order History</a>
<?php require "includes/footer.php"; ?>