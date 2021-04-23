<?php 
session_start();
$loginError = '';
if(!empty($_POST['uname']) && !empty($_POST['pass'])){
	include ('backend/users.php');
	$login = new Users();
	$user = $login->login($_POST['uname'], $_POST['pass']);
	if(!empty($user)){
		$_SESSION['username'] = $user[0]['user_name'];
		$_SESSION['userid'] = $user[0]['user_id'];
		$_SESSION['userrole'] = $user[0]['user_role'];
		$login->checkBan($_SESSION['userid']);
		header("Location:homepage.php");
	}else{
		$loginError = "Invalid username or password.";
	}
}

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/login.css"/>
<style>

</style>
</head>
<body>
<div id="login" class="lform">
	<form class="lform-content" method="POST">
		<div class="logoimg">
			<img src="uploads/logo.png" alt="logo" class="logo">
		</div>
		<?php if($loginError){?>
			<div class="loginerror">
				<?php echo $loginError; ?>
			</div>
		<?php } ?>
		<div class="lcontainer">
			<input type="text" placeholder="Username" name="uname" autocomplete="off" required>
			<div class="showpass">
			<input type="password" placeholder="Password" name="pass" id="pass" required>
			<input type="button" class="show" onclick="myFunction()" value="&#128065">
			</div>
			<button type="submit" name="submit"><span>Login <i class="material-icons">login</i><span class="icon-text"></span></button>
		</div>
	</form>
</div>
<script>
function myFunction() {
  var x = document.getElementById("pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>