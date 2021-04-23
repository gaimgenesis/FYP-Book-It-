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
<link rel="stylesheet" type="text/css" href="css/courselist.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/course.js"></script>

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
        <?php
            $cid = $_GET['id'];
            include ("backend/course.php");
            $course = new Course();
            echo $course->getCourse($cid);
		if($_SESSION['userrole'] == "1" || $_SESSION['userrole'] == "2"){
			echo '<button class="upload">Upload Material</button>';
		}
		?>
		<br/>
		<h3>Lecture Materials</h3>
    <div id="lecturemat">
		<?php
			echo $course->getLectureMat($cid, $_SESSION['userid'], $_SESSION['userrole']);
		?>
    </div>
		<h3>Lab Materials</h3>
		<div id="labmat">
    <?php
			echo $course->getLabMat($cid, $_SESSION['userid'], $_SESSION['userrole']);
		?>
    </div>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="deletecancel">
		<form action="backend/upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file" />
		<br/><br/>
		<input type="hidden" class="courseid" name="courseid" value="<?php echo $_GET['id']; ?>"/>
		<label id="listings">To: 
			<select name="opt" id="opt">
				<option value="1">Lecture Materials</option>
				<option value="2">Lab Materials</option>
			</select>
		</label>
		<br/>
		<button type="submit" name="btn-upload" class="uploadmat">Upload</button>
		</form>
	</div>    
  </div>
</div>

<div id="matmodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
  <div class="downloadmat">
		<button class="download" id="">Download</button>
		<button class="delete" id="">Delete</button>
	</div>    
  </div>
</div>

<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

var modal = document.getElementById("myModal");
var modal2 = document.getElementById("matmodal");

$(document).on('click', '.upload', function(){
	modal.style.display = "block";
});

$(document).on('click', '.mat', function(){
  modal2.style.display = "block";
  var mat_id = $(this).attr('id');
	$('.delete').attr('id', mat_id);
	$('.download').attr('id', mat_id);
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

window.onclick = function(event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>