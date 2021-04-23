<?php
session_start();
include ('backend/quiz.php');
$quiz = new Quiz();
if($_POST['action'] == 'create_quiz') {
    $quizinsert = $quiz->createQuiz($_POST['course_id'], $_POST['qname'], $_SESSION['userid']);
    $data = array(
		"quizidhidden" => $quizinsert
	);
	echo json_encode($data);
}
if($_POST['action'] == 'create_question') {
    $questioninsert = $quiz->createQuestion($_POST['qname'], $_POST['ans'], $_POST['corr'], $_POST['quiz_id']);
    $data = array(
		"quizquestion" => $questioninsert
	);
	echo json_encode($data);
}
if($_POST['action'] == 'count_question') {
    $questioncount = $quiz->countQuestion($_POST['quiz_id']);
    $data = array(
		"quescount" => $questioncount
	);
	echo json_encode($data);
}
if($_POST['action'] == 'show_next') {
    $quiznext = $quiz->showQuiz($_POST['question_id'], $_POST['limitone'], $_POST['limittwo'], $_POST['score'], $_SESSION['userid']);
    $data = array(
		"quiznext" => $quiznext
	);
	echo json_encode($data);
}
?>