<?php
require "config/db.php";
session_start();
$id=(int)($_GET['id'] ?? 0);
$stmt=$conn->prepare("SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.id=? AND p.status=1");
$stmt->bind_param("i",$id); $stmt->execute(); $product=$stmt->get_result()->fetch_assoc();
if(!$product){ die("Product not found."); }
require "includes/header.php";
?>
<div class="detail">
  <img class="product-img detail-img" src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
  <div>
    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
    <p>Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
    <h2 class="price">₹<?php echo number_format($product['price'],2); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <p>Stock: <?php echo (int)$product['stock']; ?></p>
    <?php if($product['stock']>0): ?>
    <form method="post" action="cart.php">
      <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
      <input type="hidden" name="action" value="add">
      <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
      <button class="btn" type="submit">Add to Cart</button>
    </form>
    <?php else: ?><p class="error">Out of stock</p><?php endif; ?>
  </div>
</div>
<?php require "includes/footer.php"; ?>