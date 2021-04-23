<?php
session_start();
include_once ('backend/users.php');
$user = new Users();
if($_POST['action'] == 'show_users'){
	$result = $user->getUsers($_SESSION['userid']);
	$data = array(
		"result" => $result
	);
	echo json_encode($data);
}
if($_POST['action'] == 'add_usertocourse'){
	$result = $user->addUtoC($_POST['userid'], $_POST['cid']);
	$data = array(
		"result" => $result
	);
	echo json_encode($data);
}
if($_POST['action'] == 'add_course'){
	$result = $user->addCourse($_POST['cname']);
	$data = array(
		"result" => $result
	);
	echo json_encode($data);
}
if($_POST['action'] == 'add_user'){
	$result = $user->addUser($_POST['username'], $_POST['role'], $_POST['position']);
	$data = array(
		"result" => $result
	);
	echo json_encode($data);
}
if($_POST['action'] == 'chg_password'){
	$result = $user->chgPass($_POST['cpass'], $_POST['npass'], $_SESSION['userid']);
	$data = array(
		"result" => $result
	);
	echo json_encode($data);
}
?>