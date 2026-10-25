<?php
require "config/db.php"; require "includes/auth.php";
$uid=$_SESSION['user_id']; $msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']); $mobile=trim($_POST['mobile']); $address=trim($_POST['address']); $city=trim($_POST['city']); $state=trim($_POST['state']); $pincode=trim($_POST['pincode']);
  $s=$conn->prepare("UPDATE users SET name=?,mobile=?,address=?,city=?,state=?,pincode=? WHERE id=?");
  $s->bind_param("ssssssi",$name,$mobile,$address,$city,$state,$pincode,$uid); $s->execute(); $msg="Profile updated successfully.";
}
$user=$conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
require "includes/header.php";
?>
<h1>My Profile</h1><?php if($msg): ?><p class="success"><?php echo $msg; ?></p><?php endif; ?>
<form class="form" method="post">
<input name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
<input value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
<input name="mobile" value="<?php echo htmlspecialchars($user['mobile']); ?>">
<textarea name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>
<input name="city" value="<?php echo htmlspecialchars($user['city']); ?>">
<input name="state" value="<?php echo htmlspecialchars($user['state']); ?>">
<input name="pincode" value="<?php echo htmlspecialchars($user['pincode']); ?>">
<button class="btn">Update Profile</button>
</form>
<?php require "includes/footer.php"; ?>