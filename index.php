<?php
require "config/db.php";
session_start();
$categories = $conn->query("SELECT * FROM categories WHERE status=1 ORDER BY id DESC LIMIT 6");
$products = $conn->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status=1 ORDER BY p.id DESC LIMIT 8");
require "includes/header.php";
?>
<section class="hero">
  <div>
    <h1>Made by Hand, Made with Love</h1>
    <p>Discover handcrafted decor, jewelry, art and thoughtful gifts from independent makers.</p>
    <a class="btn" href="categories.php">Shop Now</a>
  </div>
</section>

<h2>Featured Categories</h2>
<div class="grid">
<?php while($c=$categories->fetch_assoc()): ?>
  <div class="card">
    <img class="product-img" src="assets/images/<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
    <h3><?php echo htmlspecialchars($c['name']); ?></h3>
    <p><?php echo htmlspecialchars($c['description']); ?></p>
    <a class="btn small" href="products.php?category=<?php echo $c['id']; ?>">View Products</a>
  </div>
<?php endwhile; ?>
</div>

<section class="promo"><h2>Made with Love</h2><p>Every item has a story. Shop unique handmade gifts, home decor, jewelry and art. Cash on Delivery available.</p></section>

<h2>Latest Products</h2>
<div class="grid">
<?php while($p=$products->fetch_assoc()): ?>
  <div class="card">
    <img class="product-img" src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
    <p class="price">₹<?php echo number_format($p['price'],2); ?></p>
    <p><?php echo htmlspecialchars(substr($p['description'],0,80)); ?></p>
    <a class="btn small" href="product-details.php?id=<?php echo $p['id']; ?>">View Details</a>
  </div>
<?php endwhile; ?>
</div>
<?php require "includes/footer.php"; ?>