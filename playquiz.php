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
}

</style>
</head>
<body>
<!-- header -->

<!-- -->

<!-- sidebar -->

<!-- -->
<div id="main">
	<div class="title">
		<?php
		if($_SESSION['userrole'] == "1" || $_SESSION['userrole'] == "2"){
			echo "<script>alert('Incorrect userrole privileges.');</script>";
			die  ("<script>window.location.href='homepage.php'</script>");
		}
			$qid = $_GET['id'];
			include ('backend/quiz.php');
			$quiz = new Quiz();
			$qname = $quiz->getQuizName($qid);
			foreach($qname as $row){
				echo '<h1>Quiz Session: '.$row['quiz_name'].'</h1>';
			}
		?>
		<div class="quiznext">
			<?php
				echo $quiz->showQuiz($qid, 0, 1, 0, $_SESSION['userid']);
			?>
		</div>
	</div>
		<!-- <form action="quiz.php">
		<input type="submit" value="Go back to the quiz page" />
	</form> -->
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

// window.onbeforeunload = function(){
//         return "go to google instead?";
// }

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>