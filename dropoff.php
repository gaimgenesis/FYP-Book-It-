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
<link rel="stylesheet" type="text/css" href="css/dropoff.css"/>
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
    include ('backend/course.php');
    $drop = new Course();
      if($_SESSION['userrole'] == "1"){
			echo '<h1 class="titledrop">Assignment Dropoff Management</h1>';
			echo '<button class="drop">Create Dropoff</button><br/><br/>';  
      echo '<div class="dropofflist">';
			echo $drop->getDropoff($_GET['id'], $_SESSION['userid']);
      echo '</div>';
    }else if($_SESSION['userrole'] == "0"){
			echo '<h1>Assignment Submission</h1>';
      echo '<div class="dropofflist">';
			echo $drop->getDropoffStd($_GET['id'], $_SESSION['userid']);
      echo '</div>';
    }else{
        echo "<script>alert('Incorrect userrole privileges.');</script>";
        die  ("<script>window.location.href='homepage.php'</script>");
    }
		?>
</div>

<div id="dropmodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="downloadmat">
		<label for="deadline" style="font-weight:bold; font-size:18px;">Deadline:</label>
		<input type="date" id="deadline" name="deadline"><br/>
		<label for="assignname" style="font-weight:bold; font-size:18px;">Dropoff Name:</label>
		<input type="text" id="assignname" name="assignname"><br/>
		<p style="color:red">Deadline will always end at 12:00 A.M.</p>
        <button class="createdrop" id="<?php echo $_GET['id'];?>">Create</button>
	</div>    
  </div>
</div>

<div id="stdmodal" class="modal">
  <div class="modal-content3">
    <span class="close">&times;</span>
    <div class="deletecancel">
     <form action="backend/filesubmit.php" method="post" enctype="multipart/form-data">
        <br/><input type="file" name="file" />
          <br/>
          <p style="color:red; margin-top:5px; text-align:center">No resubmission are allowed</p>
          <input type="hidden" class="dropoffid" name="dropoffid" value=""/>
        <button type="submit" name="btn-upload" class="upload">Upload</button>
      </form>
    </div>    
  </div>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

$(document).ready(function() {
  $(".overdue").prop("disabled", true);
  $(".overdue").css("opacity", "0.6");
}); 

var modal = document.getElementById("dropmodal");
var modal3 = document.getElementById("stdmodal");

$(document).on('click', '.drop', function(){
    modal.style.display = "block";
});

$(document).on('click', '.proceed', function(){
    modal3.style.display = "block";
    var dropid = $(this).attr('id');
    $('.dropoffid').attr('value', dropid);
});

$(document).on('click', '.close', function(){
	modal.style.display = "none";
	modal2.style.display = "none";
	modal3.style.display = "none";
});

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

window.onclick = function(event) {
  if (event.target == modal3) {
    modal3.style.display = "none";
  }
}

var today = new Date().toISOString().split('T')[0];
document.getElementsByName("deadline")[0].setAttribute('min', today);

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>