<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- sidenav css -->
<link rel="stylesheet" type="text/css" href="css/sidebar.css"/>
<link rel="stylesheet" type="text/css" href="css/header.css"/>
<link rel="stylesheet" type="text/css" href="css/footer.css"/>
<link rel="stylesheet" type="text/css" href="css/profiles.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/profile.js"></script>

<!-- -->
<style>

html  {
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
    overflow-y: auto;
}

body {
    background: rgb(255,255,255);
    background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(213,211,211,1) 100%);
}

main .sidenav{
	position: absolute;
	top: 0;
	right: 25px;
	font-size: 36px;
	margin-left: 50px;
}

#main {
	transition: margin-left 0.5s;
	height: 100%;
	padding: 16px;
    margin-left: 85px; 
}

</style>
</head>
<body>
<!-- header -->
<?php include_once 'template/header.php';
if (!isset($_SESSION['userid'])) {
		echo "<script>alert('Please login first.');</script>";
		die  ("<script>window.location.href='login.php'</script>");
	}
?>
<!-- -->

<!-- sidebar -->
<?php 
if($_SESSION['userrole'] == "2"){
	include_once 'template/adminside.php';
  }else{
	include_once 'template/sidebar.php';
  }
?>
<!-- -->
<div id="main">
	<div class="wrapper">
		<div class="profimg">
			<img src='uploads/profiledefault.png' class='profilepic'/>
			<br/><br/>
            <button class="msgbtn">Change Password</button>
			<?php 
			include_once ('backend/users.php');
			$profile = new Users();
			?>
		</div>
		<div class="uinfo">
		<?php
			echo $profile->getProfile($_SESSION['userid']);
		?>
		</div>
	</div>
</div>

<div id="myModal" class="modal">

  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="block">
        <label>Current Password: </label>
        <input type="password" name="cpass" class="cpass" required/>
    </div>
    <div class="block">
        <label>New Password: </label>
        <input type="password" name="npass" class="npass" required/>
    </div>
    <div class="deletecancel">
		<button class="chgpass" id="">Change Password</button>
	</div>    
  </div>

</div>

<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

var modal = document.getElementById("myModal");

$(document).on('click', '.msgbtn', function(){
	var sess_id = $(this).attr('id');
	$('.delete').attr('id', sess_id);
	modal.style.display = "block";
});

$(document).on('click', '.close', function(){
	modal.style.display = "none";
});

$(document).on('click', '.cancel', function(){
	modal.style.display = "none";
});

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>