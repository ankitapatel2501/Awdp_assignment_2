<?php
require "../config/db.php";require "includes/auth.php";
if(isset($_POST['status'])){
  $id=(int)$_POST['order_id'];$status=$_POST['status'];
  $s=$conn->prepare("UPDATE orders SET order_status=? WHERE id=?");$s->bind_param("si",$status,$id);$s->execute();header("Location:orders.php");exit;
}
$res=$conn->query("SELECT * FROM orders ORDER BY id DESC");require "includes/header.php";
?>
<h1>Orders</h1>
<table><tr><th>ID</th><th>Customer</th><th>Date</th><th>Total</th><th>Payment</th><th>Payment Status</th><th>Order Status</th><th>Update</th></tr>
<?php while($o=$res->fetch_assoc()):?><tr><td>#<?php echo $o['id'];?></td><td><?php echo htmlspecialchars($o['customer_name']);?></td><td><?php echo $o['order_date'];?></td><td>₹<?php echo number_format($o['total_amount'],2);?></td><td><?php echo htmlspecialchars($o['payment_method']);?></td><td><?php echo $o['payment_status'];?></td><td><?php echo $o['order_status'];?></td><td><form method="post"><input type="hidden" name="order_id" value="<?php echo $o['id'];?>"><select name="status"><?php foreach(['Pending','Confirmed','Processing','Shipped','Delivered','Cancelled'] as $st):?><option <?php echo $o['order_status']===$st?'selected':'';?>><?php echo $st;?></option><?php endforeach;?></select><button class="btn">Save</button></form></td></tr><?php endwhile;?></table>
<?php require "includes/footer.php"; ?>