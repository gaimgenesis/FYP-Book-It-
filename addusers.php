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
<link rel="stylesheet" type="text/css" href="css/user.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/profile.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

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

</style>
</head>
<body>
<!-- header -->
<?php include_once 'template/header.php';
if (!isset($_SESSION['userid'])) {
		echo "<script>alert('Please login first.');</script>";
		die  ("<script>window.location.href='login.php'</script>");
	}
    if($_SESSION['userrole'] != "2"){
        echo "<script>alert('Incorrect user privileges.');</script>";
		die  ("<script>window.location.href='homepage.php'</script>");
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
    <h2>Add Users</h2>
    <div class='addusers'>
        <label for='name' class='name' id='optname'>Name: </label>
        <input type='text' id='username' name='name' class='naming' autocomplete="off" required>
        <label id="optname">Role: 
			<select name="opt" id="opt">
				<option value="0">Student</option>
				<option value="1">Lecturer</option>
			</select>
		</label>
		<label for='pos' class='pos' id='optname'>Intake Code/Position: </label>
        <input type='text' id='pos' name='pos' class='position' autocomplete="off" required>
		<button class="addu" id="addbtn">Add User</button>
    </div>
	<h2>Add Courses</h2>
    <div class='addusers'>
        <label for='name' class='name' id='optname'>Course Name: </label>
        <input type='text' id='coursename' name='name' class='naming' autocomplete="off" required>
		<button class="addcourse" id="addbtn">Add Course</button>
    </div>
    <h2>Manage Users</h2>
    	<div class='addusers'>
		<label for='name' class='name' id='optname'>User: </label>
			<select id='selUser' style='width: 200px;'>
				<?php 
					include_once ('backend/users.php');
					$user = new Users();
					$alluser = $user->getAllUsers();
					if(!$alluser){
						echo "<p>Error getting users</p>";
					}else{
						echo "<option value='0'>Select User</option>";
						foreach($alluser as $row){
							echo "<option value='".$row['user_id']."'>".$row['username']."</option>";
						}
					}
				?>
			</select>
			<label for='name' class='name' id='optname'>Course: </label>
			<select id='selCourse' style='width: 200px;'>
				<?php 
					$allcourse = $user->getCourseOpt();
					if(!$allcourse){
						echo "<p>Error getting courses</p>";
					}else{
						echo "<option value='0'>Select Course</option>";
						foreach($allcourse as $rowc){
							echo "<option value='".$rowc['course_id']."'>".$rowc['course_name']."</option>";
						}
					}
				?>
			</select>
		<button class="addutoc" id="addbtn2">Add User to Course</button>
    </div>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

$(document).ready(function(){
 
 // Initialize select2
 $("#selUser").select2();
 $("#selCourse").select2();
});

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>