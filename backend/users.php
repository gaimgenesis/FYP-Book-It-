<?php
class Users{
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
	public function login($user, $pass){
		$sql = "SELECT *
		FROM user
		WHERE BINARY username='".$user."'";
		$res = mysqli_query($this->dbConn, $sql);
		$success = '';
		foreach($res as $row){
			if (password_verify($pass, $row['password'])) {
				return $this->getData($sql);
			} else {
				return $success;
			}
		}
	}
	public function checkBan($uid){
		$sqldate = "SELECT * FROM consult_ban WHERE user_id = ".$uid." ";
		$res = mysqli_query($this->dbConn, $sqldate);
		if(!$res){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			foreach($res as $row){
			$date = $row['datetime'];
			}
			if($date < date("Y-m-d")){
				$sqldel = "DELETE FROM consult_ban WHERE user_id = ".$uid." ";
				mysqli_query($this->dbConn, $sqldel);
			}
		}
	}
	public function getUsers($user){
		$sql = "SELECT * FROM user WHERE user_id != ".$user." AND user_role != 2 ";
		$profile = $this->getData($sql);
		$result = '<div class="game-board">';
		foreach($profile as $uprof){
			$result .= '<div class="box" id="'.$uprof['user_id'].'">'; 
			$result .= '<img src="uploads/profiledefault.png" class="img"/>';
			$result .= '<br/><br/>';
			$result .= '<p class="text">Name: '.$uprof['username'].' <br/>';
			if($uprof['user_role'] == 1){
				$result .= 'Teacher</p>';
			}else{
				$result .= 'Student</p>';
			}
			$result .= '<br/>';
			$result .= '<a href="profile.php?id='.$uprof['user_id'].'" >';
			$result .= '</a>';
			$result .= '</div>';
		}
		$result .= '</div>';
		return $result;
	}
	public function getCourses($user){
		$sql = "SELECT course_id FROM user_course WHERE user_id = ".$user." ";
		$profile = $this->getData($sql);
		$result = '<ul class="course-list">';
		foreach($profile as $uprof){
			$sql2 = "SELECT * FROM course WHERE course_id = " .$uprof['course_id']." ";
			$coursename = $this->getData($sql2);
			foreach($coursename as $row2){
				$result .= '<li class="courseid" id="'.$row2['course_id'].'">'.$row2['course_name'].'</li>';
			}
		}
		$result .= '</ul>';
		return $result;
	}
	public function getUserinfo($uid){
		$sql = "SELECT * FROM user WHERE user_id = ".$uid." ";
		return $this->getData($sql);
	}
	public function getAllCourse(){
		$sql = "SELECT * FROM course ";
		$profile = $this->getData($sql);
		$result = '<ul class="course-list">';
		foreach($profile as $uprof){
			$result .= '<li class="courseid" id="'.$uprof['course_id'].'">'.$uprof['course_name'].'</li>';
		}
		$result .= '</ul>';
		return $result;
	}
	public function getProfile($uid){
		$sql = "SELECT * FROM user WHERE user_id = ".$uid." ";
		$info = $this->getData($sql);
		$sql2 = "SELECT course_id FROM user_course WHERE user_id = ".$uid." ";
		$courses = $this->getData($sql2);
		$display = '';
		foreach($info as $row){
			$display .= '<p>Name: '.$row['username'].' ';
			$display .= '<br/> Intake/Position: '.$row['intake'].' ';
			$display .= '<br/> Courses: </p>';
		}
		$display .= '<ul class="courses">';
		foreach($courses as $row2){
			$sql3 = "SELECT * FROM course WHERE course_id = ".$row2['course_id']." ";
			$coursename = $this->getData($sql3);
			foreach($coursename as $row3){
				$display .= '<li class="disp">'.$row3['course_name'].'</li>';
			}
		}
		$display .= '</ul>';
		return $display;
	}
	public function getRole($uid){
		$sql = "SELECT * FROM user
		WHERE user_id = '$uid'";
		return $this->getData($sql);
	}
	public function getAllUsers(){
		$sql = "SELECT * FROM user
		WHERE user_role != 2";
		return $this->getData($sql);
	}
	public function getCourseOpt(){
		$sql = "SELECT * FROM course";
		return $this->getData($sql);
	}
	public function addUtoC($uid, $cid){
	$sql = "SELECT * FROM `user_course` ORDER BY ledger_id DESC LIMIT 1"; //last row
	$result = mysqli_query($this->dbConn, $sql);
	if(!$result){
		return ('Error in query: '. mysqli_error());
			echo mysqli_error();
	}else{
		foreach($result as $row){
			$lastledid = $row['ledger_id'];
			$prevhash = $row['previous_hash'];
		}
	}
	$sql2 = "SELECT * FROM `user_course` ORDER BY ledger_id DESC LIMIT 1, 1"; //second last row
	$result2 = mysqli_query($this->dbConn, $sql2);
	if(!$result2){
		return ('Error in query: '. mysqli_error());
			echo mysqli_error();
	}else{
		foreach($result2 as $row2){
			$ledid = $row2['ledger_id'];
		}
	}
	if (hash_equals($prevhash, crypt($ledid, $prevhash))) {
		$hash = password_hash($lastledid, PASSWORD_DEFAULT);
		$sql3 = "INSERT INTO user_course (user_id, course_id, datetimestamp, previous_hash) SELECT * FROM (SELECT '".$uid."' AS user_id, '".$cid."' AS course_id, NOW() AS datetimestamp, '".$hash."' AS previous_hash) AS tmp
		WHERE NOT EXISTS (SELECT user_id, course_id FROM user_course WHERE user_id = '".$uid."' AND course_id = '".$cid."')";
	}
	$result3 = mysqli_query($this->dbConn, $sql3);
	$success = '';
	if(!$result3){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			$success = '';
		}
	return $success;
	}
	public function addCourse($cname){
		$sql = "INSERT INTO course (course_name) SELECT * FROM (SELECT '".$cname."' AS course_name) AS tmp
			WHERE NOT EXISTS (SELECT course_name FROM course WHERE course_name = '".$cname."')";
		$result = mysqli_query($this->dbConn, $sql);
		$success = '';
		if(!$result){
				return ('Error in query: '. mysqli_error());
				echo mysqli_error();
			}else{
				$success = '';
			}
		return $success;
	}
	public function addUser($uname, $role, $pos){
		$hash = password_hash("123", PASSWORD_DEFAULT);
		$sql = "INSERT INTO user (username, password, user_role, intake) 
		SELECT * FROM (SELECT '".$uname."' AS username, '".$hash."' AS password, '".$role."' AS user_role, '".$pos."' AS intake) AS tmp
			WHERE NOT EXISTS (SELECT * FROM user WHERE username = '".$uname."' AND user_role = '".$role."' AND intake = '".$pos."')";
		$result = mysqli_query($this->dbConn, $sql);
		$uid = mysqli_insert_id($this->dbConn);
		$sql2 = "INSERT INTO chat_session (user_id, session) 
		SELECT * FROM (SELECT '".$uid."' AS user_id, '0' as session) AS tmp
			WHERE NOT EXISTS (SELECT * FROM chat_session WHERE user_id = '".$uid."' AND session = '0') ";
		mysqli_query($this->dbConn, $sql2);
		$success = '';
		if(!$result){
				return ('Error in query: '. mysqli_error());
				echo mysqli_error();
			}else{
				$success = '';
			}
		return $success;
	}
	public function getNotif($uid){
		$sql = "SELECT * FROM notifications WHERE user_id = ".$uid." ORDER BY notif_date DESC";
		$res = mysqli_query($this->dbConn, $sql);
		$disp = "<ul>";
		if(!$res){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			if(mysqli_num_rows($res) == 0){
				$disp = "<p class='nonotif'>No notifications</p>";
			}
			foreach($res as $row){
				$disp .= "<li>Date: ".$row['notif_date']." ";
				$disp .= "<br/>".$row['notif_content']."</li>";
			}
		}
		$disp .= "</ul>";
		return $disp;
	}
	public function chgPass($cpass, $npass, $uid){
		$sql = "SELECT * FROM user WHERE user_id = ".$uid." ";
		$res = mysqli_query($this->dbConn, $sql);
		if(!$res){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			foreach($res as $row){
				$pass = $row['password'];
			}
			if (password_verify($cpass, $pass)) {
				$hash = password_hash($npass, PASSWORD_DEFAULT);
				$sql2 = "UPDATE user SET password = '".$hash."' WHERE user_id = ".$uid." ";
				mysqli_query($this->dbConn, $sql2);
			} else {
				echo 'Invalid password.';
			}
		}
	}
	public function getBan($uid, $profid){
		$countsql = "SELECT COUNT(*) as total FROM consult_ban WHERE user_id = ".$uid." ";
		$count = mysqli_query($this->dbConn, $countsql);
		$countno = mysqli_fetch_array($count);
		$disp = '';
		if($countno[0] >= 1){
			
		}else{
			$disp .= '<br/><button class="consultbtn" id="'.$profid.'"onlick="">Book Consultation</button>';
		}
		return $disp;
	}
}
?>