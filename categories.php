<?php
require "config/db.php";
session_start();
$result=$conn->query("SELECT * FROM categories WHERE status=1 ORDER BY name");
require "includes/header.php";
?>
<h1>Categories</h1>
<div class="grid">
<?php while($c=$result->fetch_assoc()): ?>
<div class="card">
  <img class="product-img" src="assets/images/<?php echo htmlspecialchars($c['image']); ?>" alt="<?php echo htmlspecialchars($c['name']); ?>">
  <h2><?php echo htmlspecialchars($c['name']); ?></h2>
  <p><?php echo htmlspecialchars($c['description']); ?></p>
  <a class="btn" href="products.php?category=<?php echo $c['id']; ?>">View Products</a>
</div>
<?php endwhile; ?>
</div>
<?php require "includes/footer.php"; ?>