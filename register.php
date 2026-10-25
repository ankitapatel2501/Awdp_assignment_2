<?php
require "config/db.php"; session_start();
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']); $email=trim($_POST['email']); $mobile=trim($_POST['mobile']);
  $password=$_POST['password']; $confirm=$_POST['confirm_password'];
  if($password!==$confirm) $error="Passwords do not match.";
  else{
    $check=$conn->prepare("SELECT id FROM users WHERE email=?"); $check->bind_param("s",$email); $check->execute();
    if($check->get_result()->num_rows) $error="Email already registered.";
    else{
      $hash=password_hash($password,PASSWORD_DEFAULT);
      $stmt=$conn->prepare("INSERT INTO users(name,email,mobile,password) VALUES(?,?,?,?)");
      $stmt->bind_param("ssss",$name,$email,$mobile,$hash);
      if($stmt->execute()){ $_SESSION['user_id']=$stmt->insert_id; header("Location: index.php"); exit; }
      $error="Registration failed.";
    }
  }
}
require "includes/header.php";
?>
<h1>Create Account</h1>
<?php if($error): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
<form class="form" method="post">
<input name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input name="mobile" placeholder="Mobile Number" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="confirm_password" placeholder="Confirm Password" required>
<button class="btn">Register</button>
</form>
<?php require "includes/footer.php"; ?>