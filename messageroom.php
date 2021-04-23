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
<link rel="stylesheet" type="text/css" href="css/chatmessage.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/chat.js"></script>

<!-- -->
<style>
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
<?php include_once 'template/header.php'?>
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
	<?php if(isset($_SESSION['userid']) && $_SESSION['userid']) { ?>
		<div id="mainchat">
			<div id="chatframe">
				<?php
				include ('backend/chat.php');
				$chat = new Chat();
				$logged = $chat -> getUserDetails($_SESSION['userid']);
				$nochat = false;
				echo '<div>';
				$currentSession = '';
				if(empty($logged)){
					$nochat = true;
				}else{
					foreach ($logged as $user){
						if($user['session'] == ''){
							$currentSession = 0;
						}else{
							$currentSession = $user['session'];
						}
					}
				}
				echo '</div>';				
				?>

				<?php
				echo '<ul>';
				$chatUsers = $chat->chatUsers($_SESSION['userid']);
				if(empty($chatUsers)){

				}else{
					foreach($chatUsers as $user){
						$recid = $user['user_receiver_id'];
						$active = '';
						if($recid == $currentSession){
							$active = "active";
						}
						$username = $chat->getUsers($recid);
						foreach($username as $receiver){
							$uname = $receiver['username'];
							$receiverid = $receiver['user_id'];
						}
						echo '<li id="'.$user['user_receiver_id'].'" class="contact '.$active.'" data-touserid="'.$user['user_receiver_id'].'" data-tousername="'.$uname.'">';
						echo $uname;
						echo '</li>';
					}
				}
				echo '</ul>';
				?>
		</div> 
		
		<div class="chat" id="content">
			<div class="profile" id="profile">
				<?php
				$userDetails = $chat->getUsers($currentSession);
				if(empty($userDetails)){
					"<p>No chat messages yet.</p>";
				}else{
					foreach($userDetails as $user){
						echo '<p id="userid'.$currentSession.'" class="profilelink"><a href="profile.php?id='.$user['user_id'].'">'.$user['username'].'</a></p>';
					}
				}
				?>
			</div>
			<div class="chatbox" id="conversation">
				<?php
					echo $chat->getUserChat($_SESSION['userid'], $currentSession);
				?>
			</div>
			<div class="message-input">
				<div id="reply">
					<div class="wrap">
					<?php
					if($nochat == true){

					}else{
						echo "<input type='text' class='message' id='$currentSession' placeholder='Type your message here'>";
						echo "<button class='submitchat chatButton' id='submitchat $currentSession.' onclick=''><i class='material-icons' id='icon'>&#xe163;</i></button>";
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } else {
		echo '<script>alert("Please login to proceed.")</script>';
		header("Location:../login.php");
	}?>
</div>
<!-- sidebar js-->
<script>
<?php include_once 'js/sidebar.js'?>

$(document).ready(function(){
	$(document).bind('keypress', function(e){
		if(e.keyCode == 13){
			$('.submitchat').trigger('click');
		}
	});
});

var convo = document.getElementById('conversation');
convo.scrollTop = convo.scrollHeight;

$('.submitchat').click(function(){
	var log = $('#conversation');
	log.animate({scrollTop: log.prop('scrollHeight')}, 1000);
});

</script>

<!-- footer -->
<footer>
<?php include_once 'template/footer.php'?>
</footer>
</body>
</html>