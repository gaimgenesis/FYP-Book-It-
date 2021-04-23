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
<link rel="stylesheet" type="text/css" href="css/consultation.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/consultation.js"></script>

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
	if($_SESSION['userrole'] == "0" || $_SESSION['userrole'] == "2"){
		echo "<script>alert('Incorrect userrole privileges.');</script>";
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
	<div id="box">
		<div class="btn-group">
		  <h4>Select day: </h4>
		  <button class="day" id="Monday">Monday</button>
		  <button class="day" id="Tuesday">Tuesday</button>
		  <button class="day" id="Wednesday">Wednesday</button>
		  <button class="day" id="Thursday">Thursday</button>
		  <button class="day" id="Friday">Friday</button>
		</div>
	<br/>
		<div id="conditions">
			<div id="weekly"></div>
			<label class="container">Same for this month
			  <input type="checkbox" value="weekly" id="check"/>
			  <span class="checkmark"></span>
			</label>
			<h5 class="timeslot">Select timeslot:</h5><input type="text" class="timepicker" name="time" autocomplete="off"/>
			<p class="notice">*Each session is only 1 hour</p>
			<div id="dates"></div>
			<button class="valid">Create Session</button>
		</div>
	</div>
	<br/>
	<div id="list">
		<label id="listings">This Month's Slots: 
			<select name="opt" id="opt">
				<option value="all">All</option>
				<option value="1">Booked</option>
				<option value="0">Available</option>
			</select>
		</label>
		<button class="report">Report Session</button>
		<div id="consultlist">
			<?php 
				include ('backend/consultbackend.php');
				$consult = new Consult();
				echo $consult->getConsultList(2, $_SESSION['userid']);
			?>
		</div>
	</div>
</div>
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3>Delete/Cancel Session?</h3>
    <br/>
    <div class="deletecancel">
		<button class="delete" id="">Delete</button>
		<button class="cancel">Back</button>
	</div>    
  </div>
</div>
<br/>

<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

var modal = document.getElementById("myModal");

$(document).on('click', '.session', function(){
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

$(document).ready(function(){
    $('input.timepicker').timepicker({
    	timeFormat: 'HH:mm',
	    interval: 30,
	    minTime: '10',
	    maxTime: '5:00pm',
	    defaultTime: '',
	    startTime: '10:00',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
    });
});
</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>