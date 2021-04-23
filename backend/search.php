<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "book_it";

$conn = mysqli_connect($servername, $username, $password, $databasename);
 

	if(isset($_REQUEST['term'])){
		$sql = "SELECT * FROM user WHERE username LIKE ? AND user_id != ".$_SESSION['userid']."  AND user_role != 2";

		if($statement = mysqli_prepare($conn, $sql)){

			mysqli_stmt_bind_param($statement, "s", $param_term);

			$param_term = $_REQUEST['term'].'%';
			
			if(mysqli_stmt_execute($statement)){
				$result = mysqli_stmt_get_result($statement);
				echo '<div class="game-board">';
				if(mysqli_num_rows($result) > 0){

					while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
						echo '<div class="box" id="'.$row['user_id'].'">';
						echo '<img src="uploads/profiledefault.png" class="img"/>';
						echo '<br/><br/>';
						echo '<p class="text">Name: '.$row['username'].' ';
						echo '<br/>';
						if($row['user_role'] == 1){
							echo 'Teacher</p>';
						}else{
							echo 'Student</p>';
						}
						echo '<br/>';
						echo '<a href="profile.php?id='.$row['user_id'].'" >';
						echo '</a>';
						echo '</div>';
					}
				}else{
						echo "<div class='center'>";
						echo "<p'>No matches found. </p>";
						echo "</div>";
					}
				}else{
					echo "ERROR: Could not be able to execute $sql ";
				}
				echo '</div>';
			}
			mysqli_stmt_close($statement);
		}
?>