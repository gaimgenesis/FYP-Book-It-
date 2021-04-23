<?php
session_start();
include_once 'connect.php';
if(isset($_POST['btn-upload']))
	{
		$file = $_FILES['file']['name'];
		$file_loc = $_FILES['file']['tmp_name'];
		$file_size = $_FILES['file']['size'];
		$folder = "../uploads/";

		if(move_uploaded_file($file_loc, $folder.$file))
		{
            $uid = $_SESSION['userid'];
            $did = $_POST['dropoffid'];
            $sql = "INSERT INTO submission (user_id, dropoff_id, file_name) VALUES ($uid, $did, '$file'); ";
            mysqli_query($conn, $sql);
	?>
	<script>
		alert('successfully uploaded!');
		location.href = "../assignmentdropoff.php";
	</script>
	<?php
	}
	else
	{
	?>
	<script>
		alert('error while uploading file');
		//window.location.href = 'index.php?fail';
	</script>
	<?php
	}
	}
?>