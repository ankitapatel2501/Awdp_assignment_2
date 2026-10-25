<?php
require "config/db.php"; require "includes/auth.php";
$id=(int)($_GET['id']??0); $uid=$_SESSION['user_id'];
$stmt=$conn->prepare("SELECT * FROM orders WHERE id=? AND user_id=?"); $stmt->bind_param("ii",$id,$uid); $stmt->execute(); $order=$stmt->get_result()->fetch_assoc();
if(!$order) die("Order not found.");
$items=$conn->query("SELECT oi.*,p.name FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$id");
require "includes/header.php";
?>
<h1>Order #<?php echo $order['id']; ?></h1>
<p>Status: <strong><?php echo htmlspecialchars($order['order_status']); ?></strong></p>
<table><tr><th>Product</th><th>Qty</th><th>Price</th></tr>
<?php while($i=$items->fetch_assoc()): ?><tr><td><?php echo htmlspecialchars($i['name']); ?></td><td><?php echo $i['quantity']; ?></td><td>₹<?php echo number_format($i['price'],2); ?></td></tr><?php endwhile; ?></table>
<h2>Total: ₹<?php echo number_format($order['total_amount'],2); ?></h2>
<?php require "includes/footer.php"; ?>