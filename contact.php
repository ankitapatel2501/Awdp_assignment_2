<?php
require "config/db.php"; session_start(); $msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']); $email=trim($_POST['email']); $message=trim($_POST['message']);
  $s=$conn->prepare("INSERT INTO contacts(name,email,message) VALUES(?,?,?)"); $s->bind_param("sss",$name,$email,$message); $s->execute(); $msg="Thank you! Your message has been submitted.";
}
require "includes/header.php";
?>
<h1>Contact Us</h1>
<p>Address: Ahmedabad, Gujarat, India</p><p>Phone: +91 98765 43210</p><p>Email: hello@mittiandmakers.local</p>
<?php if($msg): ?><p class="success"><?php echo $msg; ?></p><?php endif; ?>
<form class="form" method="post">
<input name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<textarea name="message" placeholder="Message" required></textarea>
<button class="btn">Send Message</button>
</form>
<?php require "includes/footer.php"; ?>