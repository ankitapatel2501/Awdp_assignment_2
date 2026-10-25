<?php
require "config/db.php"; require "includes/auth.php";
if(empty($_SESSION['cart'])){ header("Location: cart.php"); exit; }
$uid=$_SESSION['user_id'];
$user=$conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$ids=implode(',',array_map('intval',array_keys($_SESSION['cart'])));
$res=$conn->query("SELECT * FROM products WHERE id IN ($ids)");
$total=0; $items=[];
while($p=$res->fetch_assoc()){ $q=$_SESSION['cart'][$p['id']]; $total += $p['price']*$q; $p['qty']=$q; $items[]=$p; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']); $email=trim($_POST['email']); $mobile=trim($_POST['mobile']);
  $address=trim($_POST['address']); $city=trim($_POST['city']); $state=trim($_POST['state']); $pincode=trim($_POST['pincode']);
  $payment=$_POST['payment_method'] ?? 'Cash on Delivery';
  $stmt=$conn->prepare("INSERT INTO orders(user_id,customer_name,email,mobile,billing_address,shipping_address,city,state,pincode,total_amount,payment_method) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
  $stmt->bind_param("issssssssds",$uid,$name,$email,$mobile,$address,$address,$city,$state,$pincode,$total,$payment);
  $stmt->execute(); $order_id=$stmt->insert_id;
  foreach($items as $p){
    $q=$p['qty'];
    $s=$conn->prepare("INSERT INTO order_items(order_id,product_id,quantity,price) VALUES(?,?,?,?)");
    $s->bind_param("iiid",$order_id,$p['id'],$q,$p['price']); $s->execute();
    $conn->query("UPDATE products SET stock=GREATEST(stock-$q,0) WHERE id=".$p['id']);
  }
  $_SESSION['cart']=[]; $_SESSION['last_order']=$order_id;
  header("Location: order-success.php?id=".$order_id); exit;
}
require "includes/header.php";
?>
<h1>Checkout</h1>
<form class="form" method="post">
<input name="name" value="<?php echo htmlspecialchars($user['name']??''); ?>" placeholder="Customer Name" required>
<input type="email" name="email" value="<?php echo htmlspecialchars($user['email']??''); ?>" placeholder="Email" required>
<input name="mobile" value="<?php echo htmlspecialchars($user['mobile']??''); ?>" placeholder="Mobile" required>
<textarea name="address" placeholder="Billing / Shipping Address" required><?php echo htmlspecialchars($user['address']??''); ?></textarea>
<input name="city" value="<?php echo htmlspecialchars($user['city']??''); ?>" placeholder="City" required>
<input name="state" value="<?php echo htmlspecialchars($user['state']??''); ?>" placeholder="State" required>
<input name="pincode" value="<?php echo htmlspecialchars($user['pincode']??''); ?>" placeholder="Pincode" required>
<select name="payment_method"><option>Cash on Delivery</option></select>
<h2>Total: ₹<?php echo number_format($total,2); ?></h2>
<button class="btn">Place Order</button>
</form>
<?php require "includes/footer.php"; ?>