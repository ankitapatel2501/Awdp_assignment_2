<?php
require "../config/db.php";require "includes/auth.php";
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$conn->query("DELETE FROM categories WHERE id=$id");header("Location:categories.php");exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']);$desc=trim($_POST['description']);
  $s=$conn->prepare("INSERT INTO categories(name,description) VALUES(?,?)");$s->bind_param("ss",$name,$desc);$s->execute();header("Location:categories.php");exit;
}
$res=$conn->query("SELECT * FROM categories ORDER BY id DESC");require "includes/header.php";
?>
<h1>Categories</h1><form class="form" method="post"><input name="name" placeholder="Category Name" required><textarea name="description" placeholder="Description"></textarea><button class="btn">Add Category</button></form>
<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Action</th></tr><?php while($c=$res->fetch_assoc()):?><tr><td><?php echo $c['id'];?></td><td><?php echo htmlspecialchars($c['name']);?></td><td><?php echo htmlspecialchars($c['description']);?></td><td><a class="danger" href="?delete=<?php echo $c['id'];?>" onclick="return confirm('Delete category?')">Delete</a></td></tr><?php endwhile;?></table>
<?php require "includes/footer.php"; ?>