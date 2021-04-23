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
<link rel="stylesheet" type="text/css" href="css/quiz.css"/>
<link rel="stylesheet" href="timepicker/jquery.timepicker.min.css">
<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!--external js & css-->
<script type="text/javascript" src="timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="js/quizcreation.js"></script>

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
  if($_SESSION['userrole'] == "0" || $_SESSION['userrole'] == "2"){
		echo "<script>alert('Incorrect userrole privileges.');</script>";
		die  ("<script>window.location.href='homepage.php'</script>");
	}
?>
<!-- -->

<!-- sidebar -->
<?php include_once 'template/sidebar.php'?>
<!-- -->
<div id="main">
	<h2>Quiz Creation</h2>
	<div id="quescount">
		<p>Counting questions created....</p>
	</div>
	<br/>
    <label for="quesname" class="quesname">Question: </label>
    <input type="text" id="question" name="question" class="questionname" required><br/><br/>
	<label for="ansa" class="ansfield">Answer A: </label><br/>
    <input type="text" id="ansa" name="ans" class="ans" required><br/>
	<label for="ansb" class="ansfield">Answer B: </label><br/>
    <input type="text" id="ansb" name="ans" class="ans" required><br/>
	<label for="ansc" class="ansfield">Answer C: </label><br/>
    <input type="text" id="ansc" name="ans" class="ans" required><br/>
	<label for="ansd" class="ansfield">Answer D: </label><br/>
    <input type="text" id="ansd" name="ans" class="ans" required><br/><br/>
	<label id="corrans">Correct Answer: 
		<select name="ansopt" id="ansopt">
			<option value="a">A</option>
			<option value="b">B</option>
			<option value="c">C</option>
			<option value="d">D</option>
		</select>
	</label>
	<button type="submit" name="btn-upload" class="createques" id="btn <?php echo $_GET['id'];?>">Create</button>
	<button type="submit" name="btn-upload" class="cancel" id="btn2">Cancel/Finish</button>
</div>
<div id="quizmodal" class="modal">
  <div class="modal-contentquiz">
    <span class="close">&times;</span>
    <div class="downloadmat">
        <p>Once finished, you cannot add another question. Proceed?</p>
        <button class="finish">Finish</button>
	</div>    
  </div>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

var modal = document.getElementById("quizmodal");

$(document).on('click', '.cancel', function(){
  modal.style.display = "block";
});

$(document).on('click', '.close', function(){
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