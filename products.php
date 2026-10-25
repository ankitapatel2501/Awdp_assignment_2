<?php
require "config/db.php";
session_start();
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
if($category){
  $stmt=$conn->prepare("SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.category_id=? AND p.status=1 ORDER BY p.id DESC");
  $stmt->bind_param("i",$category); $stmt->execute(); $result=$stmt->get_result();
}else{
  $result=$conn->query("SELECT p.*, c.name category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status=1 ORDER BY p.id DESC");
}
require "includes/header.php";
?>
<h1>Products</h1>
<div class="grid">
<?php while($p=$result->fetch_assoc()): ?>
<div class="card">
  <img class="product-img" src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
  <h3><?php echo htmlspecialchars($p['name']); ?></h3>
  <p><?php echo htmlspecialchars($p['category_name']); ?></p>
  <p class="price">₹<?php echo number_format($p['price'],2); ?></p>
  <p><?php echo htmlspecialchars(substr($p['description'],0,100)); ?></p>
  <a class="btn small" href="product-details.php?id=<?php echo $p['id']; ?>">View Details</a>
</div>
<?php endwhile; ?>
</div>
<?php require "includes/footer.php"; ?>