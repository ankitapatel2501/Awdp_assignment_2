<?php
require "../config/db.php"; session_start();
if(!empty($_SESSION['admin_logged_in'])){header("Location:index.php");exit;}
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=trim($_POST['admin_id']);$pass=$_POST['admin_password'];
  $s=$conn->prepare("SELECT * FROM admins WHERE admin_id=? AND status=1");$s->bind_param("s",$id);$s->execute();$a=$s->get_result()->fetch_assoc();
  if($a && password_verify($pass,$a['password'])){$_SESSION['admin_logged_in']=true;$_SESSION['admin_id']=$a['id'];header("Location:index.php");exit;}
  $error="Invalid admin credentials.";
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Admin Login</title><link rel="stylesheet" href="admin.css"></head><body>
<div class="wrap"><div class="form"><h1>Admin Login</h1><?php if($error): ?><p class="error"><?php echo $error;?></p><?php endif;?><form method="post">
<input name="admin_id" placeholder="Admin ID" required><input type="password" name="admin_password" placeholder="Password" required><button class="btn">Login</button></form>
<p>Demo: admin / admin123</p></div></div></body></html>