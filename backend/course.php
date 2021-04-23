<?php
class Course{
	private $host = 'localhost';
	private $user = 'root';
	private $pass = "";
	private $db = "book_it";
	private $dbConn = false;
	public function __construct(){
		if(!$this->dbConn){
			$conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
			if($conn->connect_error){
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			}else{
				$this->dbConn = $conn;
			}
		}
	}
	private function getData($query){
		$result = mysqli_query($this->dbConn, $query);
		if(!$result){
			die('Error in query: '.mysqli_error($this->dbConn));
		}
		$data = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$data[] = $row;
		}
		return $data;
	}	
	public function getCourse($cid){
		$sql = "SELECT * FROM course WHERE course_id = ".$cid." ";
		$course = $this->getData($sql);
		$result = '<h2 class="mathead">';
		if(!$result){
            $result .= "<p class='nores'>No courses assigned to you yet.</p>";
        }else{
			foreach($course as $row){
				$result .= $row['course_name'];
			}
		}
        $result .= '</h2>';
		return $result;
	}
	public function getLectureMat($cid, $uid, $role){
		$sql = "SELECT file_id FROM material_dropoff WHERE course_id = ".$cid." AND material_type = 1";
		$course = $this->getData($sql);
		$result = '<ul class="mat-disp">';
		if(!$course){
            $result .= "<p class='nores'>No lecture materials uploaded yet.</p>";
        }else{
			foreach($course as $row){
				$sql2 = "SELECT * FROM file_upload WHERE file_id = ".$row['file_id']." ";
				$materials = $this->getData($sql2);
				foreach($materials as $row2){
					if($role == "1"){
						$result .= '<li class="mat" id="'.$row2['file_id'].'">'.$row2['material_name'].'</li>';
					}else{
						$result .= '<li class="stdmat" id="'.$row2['file_id'].'">'.$row2['material_name'].'</li>';
					}
				}
			}
		}
        $result .= '</ul>';
		return $result;
	}
	public function getLabMat($cid, $uid, $role){
		$sql = "SELECT file_id FROM material_dropoff WHERE course_id = ".$cid." AND material_type = 2";
		$course = $this->getData($sql);
		$result = '<ul class="mat-disp">';
		if(!$course){
            $result .= "<p class='nores'>No lab materials uploaded yet.</p>";
        }else{
			foreach($course as $row){
				$sql2 = "SELECT * FROM file_upload WHERE file_id = ".$row['file_id']." ";
				$materials = $this->getData($sql2);
				foreach($materials as $row2){
					if($role == "1"){
						$result .= '<li class="mat" id="'.$row2['file_id'].'">'.$row2['material_name'].'</li>';
					}else{
						$result .= '<li class="stdmat" id="'.$row2['file_id'].'">'.$row2['material_name'].'</li>';
					}
				}
			}
		}
        $result .= '</ul>';
		return $result;
	}
	public function delete_material($mid){
		$sql = "DELETE FROM material_dropoff WHERE file_id = ".$mid." ";
		$result = mysqli_query($this->dbConn, $sql);
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			$sql2 = "DELETE FROM file_upload WHERE file_id = ".$mid." ;";
			$result2 = mysqli_query($this->dbConn, $sql2);
			if(!$result2){
				return ('Error in query: '. mysqli_error());
				echo mysqli_error();
			}else{
				return "Success.";
			}
		}
	}
	public function createDropoff($date, $cid, $name, $uid){
		$sql = "INSERT INTO assignment_dropoff (dropoff_name, course_id, user_id, deadline) VALUES ('".$name."', ".$cid.", ".$uid.", STR_TO_DATE('".$date."', '%Y-%m-%d')) ";
		$result = mysqli_query($this->dbConn, $sql);
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			$dropofflist = $this->getDropoff($cid, $uid);
			$data = array(
				"dropofflist" => $dropofflist
			);
			echo json_encode($data);
		}
	}
	public function getDropoff($cid, $uid){
		$sql = "SELECT * FROM assignment_dropoff WHERE course_id = ".$cid." AND user_id = ".$uid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$dropoff = "<ul>";
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			foreach($result as $row){
				if(strtotime($row['deadline']) < strtotime(date("Y-m-d"))){
					$dropoff .= "<li class='expired' id='".$row['dropoff_id']."'>".$row['dropoff_name']."<br/>";
				}else{
					$dropoff .= "<li class='ongoing' id='".$row['dropoff_id']."'>".$row['dropoff_name']."<br/>";
				}
				$dropoff .= "Deadline: ".$row['deadline']." </li>";
			}
		}
		$dropoff .= "</ul>";
		return $dropoff;
	}
	public function getDropoffStd($cid, $uid){
		$sql = "SELECT * FROM assignment_dropoff WHERE course_id = ".$cid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$dropoff = "<ul>";
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}
		if(mysqli_num_rows($result)==0){
			$dropoff .= "<p class='nodrop'>No submission dropoff point has been made yet. </p>";
		}else{
			foreach($result as $row){
				if(strtotime($row['deadline']) < strtotime(date("Y-m-d"))){
					$dropoff .= "<li class='overdue' id='".$row['dropoff_id']."'>".$row['dropoff_name']."<br/>";
				}else{
					$sql2 = "SELECT * FROM submission WHERE dropoff_id = ".$row['dropoff_id']." AND user_id = ".$uid." ";
					$result2 = mysqli_query($this->dbConn, $sql2);
					if (mysqli_num_rows($result2)==0){
						$dropoff .= "<li class='proceed' id='".$row['dropoff_id']."'>".$row['dropoff_name']."<br/>";
					}else{
						$dropoff .= "<li class='overdue' id='".$row['dropoff_id']."'>".$row['dropoff_name']."<br/>";
					}
				}
				$dropoff .= "Deadline: ".$row['deadline']." </li>";
			}
		}
		$dropoff .= "</ul>";
		return $dropoff;
	}
	public function getSubmissions($dropid){
		$sql = "SELECT * FROM submission WHERE dropoff_id = ".$dropid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$dropoff = "<ul>";
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			foreach($result as $row){
				$sql2 = "SELECT * FROM user WHERE user_id = ".$row['user_id']." ";
				$result2 = mysqli_query($this->dbConn, $sql2);
				if(!$result2){
					return ('Error in query: '. mysqli_error($this->dbConn));
					echo mysqli_error();
				}else{
					foreach($result2 as $row2){
						$sql3 = "SELECT * FROM grading WHERE user_id = ".$row['user_id']." ";
						$result3 = mysqli_query($this->dbConn, $sql3);
						if(!$result3){
							return ('Error in query: '. mysqli_error($this->dbConn));
							echo mysqli_error();
						}else{
							if(mysqli_num_rows($result3) == 0){
								$dropoff .= "<li class='submitli' id='".$row['submission_id']."'>Name: ".$row2['username']." ";
							}else{
								$dropoff .= "<li class='submitli disabled' id='".$row['submission_id']."'>Name: ".$row2['username']." ";
							}
							$dropoff .= "<br/>".$row['file_name']."</li>";
						}
					}
				}
			}
		}
		$dropoff .= "</ul>";
		return $dropoff;
	}
	public function getFile($sid){
		$sql = "SELECT * FROM submission WHERE submission_id = ".$sid." ";
		$course = $this->getData($sql);
		$result = '';
		if(!$course){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
        }else{
			foreach($course as $row){
				$sql2 = "SELECT * FROM assignment_dropoff WHERE dropoff_id = ".$row['dropoff_id']." ";
				$result2 = $this->getData($sql2);
				if(!$result2){
					return ('Error in query: '. mysqli_error($this->dbConn));
					echo mysqli_error();
				}else{
					foreach($result2 as $row2){
						$result .= "<p class='courseid' id='".$row2['course_id']."' hidden></p>";
					}
				}
				$result .= "<p class='names'>".$row['file_name']."</p>";
				$result .= "<p class='dropoff' hidden>".$row['dropoff_id']."</p>";
				$result .= "<button id=".$row['submission_id']." class='dlbtn'>Download file</button><br/>";
				$result .= "<label for='comments' class='names'>Comments:</label><br/>";
				$result .= "<textarea id='comments' name='comments' style='resize: none; width: 100%;' rows='10'></textarea><br><br>";
				$result .= "<label for='marks' class='names'>Marks: </label>";
				$result .= "<input type='text' id='marks' name='marks' class='marking' required><br/>";
				$result .= "<button class='gradebtn' id='".$row['user_id']."'>Submit grading</button><br/>";
			}
		}
		return $result;
	}
	public function insertGrading($cmt, $marks, $cid, $uid, $drop){
		$sql = "INSERT INTO grading (user_id, marks, comments, course_id, dropoff_id) VALUES (".$uid.", ".$marks.", '".$cmt."', ".$cid.", ".$drop.") ";
		$result = mysqli_query($this->dbConn, $sql);
		$success = '';
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			$success .= 'true';
		}
		return $success;
	}
	public function getGrades($uid){
		$sql = "SELECT * FROM grading WHERE user_id = ".$uid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$success = '<ul>';
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			if(mysqli_num_rows($result) == 0){
				$success .= '<p>No grades have been submitted yet</p>';
			}else{
				foreach($result as $row){
					$sql2 = "SELECT * FROM course WHERE course_id = ".$row['course_id']." ";
					$result2 = mysqli_query($this->dbConn, $sql2);
					if(!$result2){
						return ('Error in query: '. mysqli_error($this->dbConn));
						echo mysqli_error();
					}else{
						foreach($result2 as $row2){
							$success .= '<li class="coursemarks" id ='.$row['course_id'].'>'.$row2['course_name'].'</li>';
						}
					}
				}
			}
		}
		$success .= '</ul>';
		return $success;
	}
	public function openDrop($cid, $uid){
		$sql = "SELECT * FROM assignment_dropoff WHERE course_id = ".$cid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$checkgrade = '<h3 style="display:inline-block">-Dropoff Lists</h3>';
		$checkgrade .= '<button class="return">Go back</button>';
		$checkgrade .= '<ul>';
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			if(mysqli_num_rows($result) == 0){
				$checkgrade .= '<p>No grades have been submitted yet</p>';
			}else{
				foreach($result as $row){
					$checkgrade .= '<li class="seegrades" id='.$row['dropoff_id'].'>'.$row['dropoff_name']."</li>";
				}
			}
		}
		$checkgrade .= '</ul>';
		return $checkgrade;
	}
	public function getFeedback($drop, $uid){
		$sql = "SELECT * FROM grading WHERE user_id = ".$uid." AND dropoff_id = ".$drop." ";
		$result = mysqli_query($this->dbConn, $sql);
		$gradedisp = '';
		if(!$result){
			return ('Error in query: '. mysqli_error($this->dbConn));
			echo mysqli_error();
		}else{
			if(mysqli_num_rows($result) == 0){
				$gradedisp .= '<p>No grades have been submitted yet</p>';
			}else{
				foreach($result as $row){
					$gradedisp .= "<label for='comments' class='names'>Comments:</label><br/>";
					$gradedisp .= "<textarea id='comments' name='comments' style='resize: none; width: 100%;' rows='5' readonly>".$row['comments']."</textarea><br><br>";
					$gradedisp .= "<label for='marks' class='names'>Marks: </label>".$row['marks']."";
				}
			}
		}
		return $gradedisp;
	}
}
?>