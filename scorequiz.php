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
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/assignment.js"></script>

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

html  {
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
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
	padding: 16px;
	margin-left: 85px; 
}

.scoretable{
	border-collapse: collapse;
  	width: 100%;
	font-size: 20px;
	margin-left: auto;
	margin-right: auto;
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
<?php include_once 'template/sidebar.php'?>
<!-- -->
<div id="main">
<h2>Score List for Quiz</h2>
	<div class="gradingarea">
		<?php 
		if($_SESSION['userrole'] == "0" || $_SESSION['userrole'] == "2"){
			echo "<script>alert('Incorrect userrole privileges.');</script>";
			die  ("<script>window.location.href='homepage.php'</script>");
		}
			$qid = $_GET['id'];
			include('backend/quiz.php');
			$quiz = new Quiz();
			echo $quiz->getScore($qid);
		?>
	</div>
</div>
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