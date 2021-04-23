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
<script type="text/javascript" src="js/quiz.js"></script>

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
<?php include_once 'template/sidebar.php'?>
<!-- -->
<div id="main">
<?php
  include ("backend/quiz.php");
  $quiz = new Quiz();
  $cid = $_GET['id'];
  if($_SESSION['userrole'] == "1"){
    echo '<h2 class="quizlist">List of Quizzes</h2>';
    echo '<button class="create">Create Quiz</button><br/><br/>';
    echo '<div>';
    echo $quiz->getQuizList($cid, $_SESSION['userid']);
    echo '</div>';
  }else if($_SESSION['userrole'] == "0"){
    echo '<h2 class="quizlist">List of Quizzes</h2><br/><br/>';
    echo $quiz->getQuizListStd($cid);
  }else{
      echo "<script>alert('Incorrect userrole privileges.');</script>";
      die  ("<script>window.location.href='homepage.php'</script>");
  }
?>
</div>
<div class="quizidhidden"></div>
<div id="quizmodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="downloadmat">
        <label for="qname" class="qname">Quiz name:</label>
        <input type="text" id="qname" name="qname" class="qnamefield" required><br/><br/>
        <button class="createquiz" id="<?php echo $_GET['id'];?>">Create</button>
	</div>    
  </div>
</div>

<div id="playmodal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="downloadmat">
    <h3>Play quiz?</h3>
        <button class="play" id="">Play</button>
	</div>    
  </div>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

var modal = document.getElementById("quizmodal");
var modal2 = document.getElementById("playmodal");

$(document).on('click', '.create', function(){
    modal.style.display = "block";
});

$(document).on('click', '.playquiz', function(){
  var quiz_id = $(this).attr('id');
	$('.play').attr('id', quiz_id);
  modal2.style.display = "block";
});

$(document).on('click', '.close', function(){
	modal.style.display = "none";
	modal2.style.display = "none";
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