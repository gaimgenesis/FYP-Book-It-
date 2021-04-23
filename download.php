<?php
include_once 'backend/connect.php';
if(isset($_GET['file_id'])){
	$id = $_GET['file_id'];

	$sql = "SELECT * FROM file_upload WHERE file_id = $id";
	$result = mysqli_query($conn, $sql);
	$file = mysqli_fetch_assoc($result);
	$filepath = 'uploads/'.$file['material_name'];

	if(file_exists($filepath)){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename= ' . basename($filepath));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' .filesize('uploads/' . $file['material_name']));
		readfile('uploads/' . $file['material_name']);
	}
}
?>