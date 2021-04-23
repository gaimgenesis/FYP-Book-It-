<?php
session_start();
include ('backend/consultbackend.php');
$consult = new Consult();
if($_POST['action'] == 'update_weekly') {
	$weekly = $consult->get_weekly($_POST['day'], $_POST['weekly']);
	$data = array(
		"weekly" => $weekly
	);
	echo json_encode($data);
}
if($_POST['action'] == 'update_list') {
	$list = $consult->getConsultList($_POST['opt'], $_SESSION['userid']);
	$data = array(
		"consultlist" => $list
	);
	echo json_encode($data);
}
if($_POST['action'] == 'book_session') {
	$consult->bookConsult($_POST['sess_id'], $_SESSION['userid']);
}
if($_POST['action'] == 'cancel_session') {
	$consult->cancelConsult($_POST['reason'], $_POST['sess_id'], $_SESSION['userid']);
}
if($_POST['action'] == 'report_session') {
	$consult->reportConsult($_POST['session_id'], $_SESSION['userid']);
}
?>