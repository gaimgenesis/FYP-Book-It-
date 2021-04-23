<?php
session_start();
include ('backend/consultbackend.php');
$consult = new Consult();
if($_POST['action'] == 'make_consultation') {
	$consult->insert_consultation($_POST['date'], $_POST['start'], $_POST['end'], $_SESSION['userid']);
}
if($_POST['action'] == 'delete_consultation') {
	$consult->delete_consultation($_POST['opt'], $_POST['session_id'], $_SESSION['userid']);
}
?>