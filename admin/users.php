<?php
require "../config/db.php";require "includes/auth.php";
if(isset($_GET['delete'])){$id=(int)$_GET['delete'];$conn->query("UPDATE users SET status=0 WHERE id=$id");header("Location:users.php");exit;}
$q=trim($_GET['q']??'');
$stmt=$conn->prepare("SELECT * FROM users WHERE name LIKE CONCAT('%',?,'%') OR email LIKE CONCAT('%',?,'%') ORDER BY id DESC");$stmt->bind_param("ss",$q,$q);$stmt->execute();$res=$stmt->get_result();
require "includes/header.php";
?>
<h1>Users</h1><form><input name="q" placeholder="Search users" value="<?php echo htmlspecialchars($q);?>"><button class="btn">Search</button></form>
<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Status</th><th>Action</th></tr>
<?php while($u=$res->fetch_assoc()):?><tr><td><?php echo $u['id'];?></td><td><?php echo htmlspecialchars($u['name']);?></td><td><?php echo htmlspecialchars($u['email']);?></td><td><?php echo htmlspecialchars($u['mobile']);?></td><td><?php echo $u['status']?'Active':'Inactive';?></td><td><a class="danger" href="?delete=<?php echo $u['id'];?>" onclick="return confirm('Deactivate user?')">Deactivate</a></td></tr><?php endwhile;?></table>
<?php require "includes/footer.php"; ?>