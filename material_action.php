<?php
session_start();
include ('backend/course.php');
$course = new Course();
if($_POST['action'] == 'delete_material') {
	$course->delete_material($_POST['mat_id']);
}
if($_POST['action'] == 'update_lablist') {
	$list = $course->getLabMat($_POST['course_id'], $_SESSION['userid'], $_SESSION['userrole']);
	$data = array(
		"labmat" => $list
	);
	echo json_encode($data);
}
if($_POST['action'] == 'update_lecturelist') {
	$list = $course->getLectureMat($_POST['course_id'], $_SESSION['userid'], $_SESSION['userrole']);
	$data = array(
		"lecturemat" => $list
	);
	echo json_encode($data);
}
if($_POST['action'] == 'create_dropoff') {
	$course->createDropoff($_POST['date'], $_POST['cid'], $_POST['name'], $_SESSION['userid']);
}
if($_POST['action'] == 'insert_grading') {
	$course->insertGrading($_POST['comments'], $_POST['marks'], $_POST['courseid'], $_POST['uid'], $_POST['drop']);
}
if($_POST['action'] == 'open_dropoff') {
	$checkgrade = $course->openDrop($_POST['courseid'], $_SESSION['userid']);
	$data = array(
		"checkgrade" => $checkgrade
	);
	echo json_encode($data);
}
if($_POST['action'] == 'get_grades') {
	$checkgrade = $course->getGrades($_SESSION['userid']);
	$data = array(
		"checkgrade" => $checkgrade
	);
	echo json_encode($data);
}
if($_POST['action'] == 'get_feedback') {
	$gradedisp = $course->getFeedback($_POST['dropoffid'], $_SESSION['userid']);
	$data = array(
		"gradedisp" => $gradedisp
	);
	echo json_encode($data);
}
?>