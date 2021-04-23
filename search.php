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
<link rel="stylesheet" type="text/css" href="css/searchprofile.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/profile.js"></script>

<!-- -->
<style>
.container{
	display: block;
	position: relative;
	padding-left: 35px;
	margin-bottom: 12px;
	margin-top: 12px;
	margin-left: 180px;
	cursor: pointer;
	font-size: 20px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}

.container input{
	opacity: 0;
	cursor: pointer;
	height: 0;
	width: 0;
}

html, body  {
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
    overflow-y: auto;
}

main .sidenav{
	position: absolute;
	top: 0;
	right: 25px;
	font-size: 36px;
	margin-left: 50px;
}

#main {
	margin: 0;
	transition: margin-left 0.5s;
	padding: 16px;
	margin-left: 85px; 
	background: rgb(255,255,255);
	background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(173,173,173,1) 100%);
	height: 100%;
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
<div class="search-box">
        <input class="searchbox" type="text" autocomplete="off" placeholder="Search user..." />
    	<br/>
    	<br/>
        <div class="result">
        	<?php
        	include_once ("backend/users.php");
        	$user = new Users();
        	echo $user->getUsers($_SESSION['userid']);
        	?>
        </div>
    </div>
</div>
<br/>

<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>
</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>