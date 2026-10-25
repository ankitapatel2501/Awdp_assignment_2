<?php
require "config/db.php";
session_start();
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $action=$_POST['action'] ?? '';
  $pid=(int)($_POST['product_id'] ?? 0);
  if($action==='add'){
    $qty=max(1,(int)($_POST['quantity'] ?? 1));
    $_SESSION['cart'][$pid]=($_SESSION['cart'][$pid]??0)+$qty;
  } elseif($action==='update'){
    foreach(($_POST['qty']??[]) as $id=>$qty){
      $id=(int)$id; $qty=(int)$qty;
      if($qty<=0) unset($_SESSION['cart'][$id]); else $_SESSION['cart'][$id]=$qty;
    }
  } elseif($action==='remove'){
    unset($_SESSION['cart'][$pid]);
  }
  header("Location: cart.php"); exit;
}
$items=[]; $total=0;
if($_SESSION['cart']){
  $ids=implode(',',array_map('intval',array_keys($_SESSION['cart'])));
  $res=$conn->query("SELECT * FROM products WHERE id IN ($ids)");
  while($p=$res->fetch_assoc()){
    $qty=$_SESSION['cart'][$p['id']];
    $subtotal=$p['price']*$qty; $total+=$subtotal;
    $p['qty']=$qty; $p['subtotal']=$subtotal; $items[]=$p;
  }
}
require "includes/header.php";
?>
<h1>Shopping Cart</h1>
<?php if(!$items): ?><p>Your cart is empty.</p><a class="btn" href="products.php">Continue Shopping</a>
<?php else: ?>
<form method="post">
<input type="hidden" name="action" value="update">
<table><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr>
<?php foreach($items as $p): ?>
<tr>
<td><?php echo htmlspecialchars($p['name']); ?></td>
<td>₹<?php echo number_format($p['price'],2); ?></td>
<td><input type="number" name="qty[<?php echo $p['id']; ?>]" value="<?php echo $p['qty']; ?>" min="1"></td>
<td>₹<?php echo number_format($p['subtotal'],2); ?></td>
<td><button class="danger" formaction="cart.php" name="action" value="remove" type="submit">Remove</button>
<input type="hidden" name="product_id" value="<?php echo $p['id']; ?>"></td>
</tr>
<?php endforeach; ?>
</table>
<button class="btn" type="submit">Update Cart</button>
</form>
<h2>Total: ₹<?php echo number_format($total,2); ?></h2>
<a class="btn" href="checkout.php">Proceed to Checkout</a>
<?php endif; ?>
<?php require "includes/footer.php"; ?>