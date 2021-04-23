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
		$sql = "INSERT INTO file_upload (material_name, file_size) VALUES ('$file', '$file_size');";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			echo "Error: ";
			echo $sql;
		}else{
			$fid = mysqli_insert_id($conn);
		}
		$uid = $_SESSION['userid'];
		$cid = $_POST['courseid'];
		$type = $_POST['opt'];
		$sql2 = "INSERT INTO material_dropoff (user_id, file_id, course_id, material_type) VALUES ($uid, $fid, $cid, $type); ";
		mysqli_query($conn, $sql2);
	?>
	<script>
		alert('successfully uploaded!');
		location.href = "../coursemat.php?id="+<?php echo $cid;?>;
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