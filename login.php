<?php
require "config/db.php"; session_start();
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email']); $password=$_POST['password'];
  $stmt=$conn->prepare("SELECT * FROM users WHERE email=? AND status=1");
  $stmt->bind_param("s",$email); $stmt->execute(); $u=$stmt->get_result()->fetch_assoc();
  if($u && password_verify($password,$u['password'])){ $_SESSION['user_id']=$u['id']; header("Location: index.php"); exit; }
  $error="Invalid email or password.";
}
require "includes/header.php";
?>
<h1>Login</h1>
<?php if($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
<form class="form" method="post">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button class="btn">Login</button>
</form>
<?php require "includes/footer.php"; ?>