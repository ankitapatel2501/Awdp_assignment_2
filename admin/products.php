<?php
require "../config/db.php";require "includes/auth.php";
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$conn->query("DELETE FROM products WHERE id=$id");header("Location:products.php");exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $cat=(int)$_POST['category_id'];$name=trim($_POST['name']);$price=(float)$_POST['price'];$discount=(float)$_POST['discount'];$desc=trim($_POST['description']);$stock=(int)$_POST['stock'];
  $s=$conn->prepare("INSERT INTO products(category_id,name,price,discount,description,stock) VALUES(?,?,?,?,?,?)");$s->bind_param("isddsi",$cat,$name,$price,$discount,$desc,$stock);$s->execute();header("Location:products.php");exit;
}
$cats=$conn->query("SELECT * FROM categories WHERE status=1 ORDER BY name");$res=$conn->query("SELECT p.*,c.name category FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC");require "includes/header.php";
?>
<h1>Products</h1><form class="form" method="post">
<select name="category_id" required><option value="">Select Category</option><?php while($c=$cats->fetch_assoc()):?><option value="<?php echo $c['id'];?>"><?php echo htmlspecialchars($c['name']);?></option><?php endwhile;?></select>
<input name="name" placeholder="Product Name" required><input type="number" step="0.01" name="price" placeholder="Price" required><input type="number" step="0.01" name="discount" placeholder="Discount">
<textarea name="description" placeholder="Description"></textarea><input type="number" name="stock" placeholder="Stock" required><button class="btn">Add Product</button></form>
<table><tr><th>ID</th><th>Category</th><th>Name</th><th>Price</th><th>Discount</th><th>Stock</th><th>Status</th><th>Action</th></tr>
<?php while($p=$res->fetch_assoc()):?><tr><td><?php echo $p['id'];?></td><td><?php echo htmlspecialchars($p['category']);?></td><td><?php echo htmlspecialchars($p['name']);?></td><td>₹<?php echo $p['price'];?></td><td><?php echo $p['discount'];?>%</td><td><?php echo $p['stock'];?></td><td><?php echo $p['status']?'Active':'Inactive';?></td><td><a class="danger" href="?delete=<?php echo $p['id'];?>" onclick="return confirm('Delete product?')">Delete</a></td></tr><?php endwhile;?></table>
<?php require "includes/footer.php"; ?>