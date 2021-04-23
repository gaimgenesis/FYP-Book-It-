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

.gradingarea{
    background-color: white;
	border: 4px solid black;
	padding: 10px 10px;
}

.names{
	display: inline-block;
	margin-right: 10px;
	font-weight: bold;
	font-size: 20px;
}

.dlbtn , .return{
  background-color: #ccc;
  border: solid gray;
  padding: 10px;
  width: 150px;
  text-decoration: none;
  font-size: 16px;
  margin-left: 10px;
  margin-bottom: 20px;
  transition-duration: 0.2s;
  cursor: pointer;
}

.gradebtn{
  background-color: #ccc;
  border: solid gray;
  padding: 10px;
  width: 150px;
  text-decoration: none;
  font-size: 16px;
  transition-duration: 0.2s;
  cursor: pointer;
  margin-left: 580px;
}

.dlbtn:hover, .gradebtn:hover, .return:hover{
  background-color: #A9A9A9;
  color: white;
}

.checkgrade{
    list-style-type: none;
}
  
.checkgrade li{
    background-color: lightgrey;
    font-size: 20px;
    position: relative;
    display: inline-block;
    border: 1px solid black;
    width: 70%;
    padding: 10px 0 10px 10px;
    margin-bottom: 5px;
    cursor: pointer;
}

.checkgrade li:hover{
    background-color: white;
}

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 230px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #f2f2f2;
  margin: auto;
  padding: 10px;
  border: 1px solid #888;
  width: 30%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  right: 0;
  padding-bottom: 10px;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
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
<?php
include('backend/course.php');
$course = new Course();
if($_SESSION['userrole'] == "1"){
	echo '<h2>Grading</h2>';
	echo '<div class="gradingarea">';
				$submitid = $_GET['id'];
				echo $course->getFile($submitid);
	echo '</div>';
}else if($_SESSION['userrole'] == "0"){
	echo '<h2>Assignment Grades</h2>';
	echo '<div class="checkgrade">';
	echo $course->getGrades($_SESSION['userid']);
	echo '</div>';
}else{
		echo "<script>alert('Incorrect userrole privileges.');</script>";
		die  ("<script>window.location.href='homepage.php'</script>");
}
?>
</div>

<div id="grademodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
  	<div class="gradedisp">
		
	</div>    
  </div>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

$('#marks').keypress(function(e) {
    var a = [];
    var k = e.which;
    
    for (i = 48; i < 58; i++)
        a.push(i);
    
    if (!(a.indexOf(k)>=0))
        e.preventDefault();

	if ($(this).val() > 100){
    alert("No numbers above 100");
    $(this).val('');
  }
});

var modal = document.getElementById("grademodal");

$(document).on('click', '.seegrades', function(){
	modal.style.display = "block";
});

$(document).on('click', '.close', function(){
	modal.style.display = "none";
	modal2.style.display = "none";
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