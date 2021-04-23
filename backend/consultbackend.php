<?php
class Consult{
	private $host = 'localhost';
	private $user = 'root';
	private $pass = "";
	private $db = "book_it";
	private $consultTable = 'consultation';
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
			die('Error in query: '. mysqli_error($this->dbConn));
		}
		$data = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$data[] = $row;
		}
		return $data;
	}	
	public function getUsers($uid){
		$sql = "SELECT * FROM user
		WHERE user_id = '$uid'";
		return $this->getData($sql);
	}
	public function get_weekly($day, $weekly){
		$dateTime = new DateTime(''.$day.' this week');
		if($weekly == "true"){
			$thisMonth = $dateTime->format('m');
		}else{
			$thisMonth = $dateTime->format('w');
		}
		$date = " ";
		while ($dateTime->format('m') === $thisMonth) {
			$date .= "<p class = 'dateid' hidden>" .$dateTime->format('Y-m-d'). "</p>";
		    $dateTime->modify('next '.$day.'');
		}
		$date .= "<p class = 'dateid' hidden>" .$dateTime->format('Y-m-d'). "</p>";
		return $date;
	}
	public function get_dates($day, $weekly){
		$dateTime = new DateTime(''.$day.' this week');
		if($weekly == "true"){
			$thisMonth = $dateTime->format('m');
		}else{
			$thisMonth = $dateTime->format('w');
		}
		while ($dateTime->format('m') === $thisMonth) {
			$date = $dateTime->format('Y-m-d');
		    $dateTime->modify('next '.$day.'');
		}
		return $date;
	}
	public function update_weekly($day, $weekly){
		$showdates = $this->get_dates($day, $weekly); 
		$data = array(
			"date" => $showdates
		);
		return $data;
	}
	public function insert_consultation($date, $start, $end, $userid){
		foreach($date as $condate){
			$sql = "INSERT INTO consultation (consult_date, start_time, end_time, booking_status, user_id)
					SELECT * FROM (SELECT '".$condate."' AS consult_date, '".$start."' AS start_time, '".$end."' AS end_time, '0' AS booking_status, '".$userid."' AS user_id) AS tmp
					WHERE NOT EXISTS (
					    SELECT consult_date, start_time, end_time FROM consultation WHERE consult_date = '".$condate."' AND start_time = '".$start."' AND end_time = '".$end."' AND booking_status = '0' AND user_id = '".$userid."'
					)";
			$result = mysqli_query($this->dbConn, $sql);
		}
		if(!$result){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			$consultlist = $this->getConsultList(2, $userid);
			$data = array(
				"consultlist" => $consultlist
			);
			echo json_encode($data);
		}
	}
	public function getConsultList($opt, $uid){
		if($opt != '1' && $opt != '0'){
			$query = "SELECT * FROM consultation WHERE user_id = '".$uid."' AND MONTH(consult_date) = MONTH(CURRENT_DATE) ORDER BY consult_date ASC ";
		}else{
			$query = "SELECT * FROM consultation WHERE user_id = '".$uid."' AND MONTH(consult_date) = MONTH(CURRENT_DATE) AND booking_status = '".$opt."' ORDER BY consult_date ASC ";
		}
		$result = $this->getData($query);
		$consultlist = '<ul>';
		if(!$result){
			$consultlist .= '<p style="font-size: 20px; text-align: center;">No consultation lists set yet</p>';
		}else{
		foreach($result as $val){
			if($val['booking_status'] == '1'){
				$consultlist .= '<li class="session booked" id="'.$val['consult_id'].'">';				
			}else{
				$consultlist .= '<li class="session conlist" id="'.$val['consult_id'].'">';
			}
			$consultlist .= '<p>Consultation Date: '.$val['consult_date'].' ';
			$consultlist .= '<br/>';
			$consultlist .= ' Time: ' .$val['start_time'].' to ' .$val['end_time'].' ';
			if($val['booking_status'] == '1'){
				$uid = "SELECT * FROM user WHERE user_id = ".$val['booked_user']." ";
				$user = $this->getData($uid);
				foreach($user as $username){
					$consultlist .= '<br/>';
					$consultlist .= ' Booked by: '.$username['username'].' ';
				}			
			}
			$consultlist .= '</p>';
			$consultlist .= '</li>';
		}
	}
		$consultlist .= '</ul>';
		return $consultlist;
	}
	public function getConsultSlots($userid){
		$query = "SELECT * FROM ".$this->consultTable." WHERE user_id = '".$userid."' AND consult_date >= CURDATE() AND booking_status = '0' ORDER BY consult_date ASC ";
		$result = $this->getData($query);
		$consultlist = '<ul class="consultdisp">';
		if(!$result){
			$consultlist .= '<p class="noconsult">No consultations set for this month.</p>';
		}else{
			foreach($result as $val){
				$consultlist .= '<li class="conlist" id="'.$val['consult_id'].'">';
				$consultlist .= '<p>Consultation Date: '.$val['consult_date'].' ';
				$consultlist .= '<br/>';
				$consultlist .= ' Time: ' .$val['start_time'].' to ' .$val['end_time'].' ';
				if($val['booking_status'] == '1'){
					$uid = "SELECT * FROM user WHERE user_id = '".$val['booked_user']."' ";
					$user = $this->getData($uid);
					foreach($user as $username){
						$consultlist .= '<br/>';
						$consultlist .= ' Booked by: '.$username['username'].' ';
					}			
				}
				$consultlist .= '</p>';
				$consultlist .= '</li>';
			}
		}
		$consultlist .= '</ul>';
		return $consultlist;
	}
	public function delete_consultation($opt, $sessionid, $userid){
		$seuid = "SELECT * FROM consultation WHERE consult_id = ".$sessionid." ";
		$resultid = mysqli_query($this->dbConn, $seuid);
		if(!$resultid){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			foreach($resultid as $row){
				$studentid = $row['booked_user'];
			}
			if(empty($userid)){

			}else{
				$finduid = "SELECT * FROM user WHERE user_id = ".$userid." ";
				$uid = mysqli_query($this->dbConn, $finduid);
				if(!$uid){
					return ('Error in query: '. mysqli_error());
					echo mysqli_error();
				}else{
					foreach($uid as $row2){
						$uname = $row2['username'];
					}
				}
				$sql3 = "INSERT INTO notifications (user_id, notif_content, from_user, notif_date) VALUES (".$studentid.", 'Consultation from ".$uname." has been cancelled.', ".$userid.", NOW()) ";
				mysqli_query($this->dbConn, $sql3);
			}
		}
		$sql = "DELETE FROM consultation WHERE consult_id = ".$sessionid." ";
		$result = mysqli_query($this->dbConn, $sql);
		if(!$result){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			$consultlist = $this->getConsultList($opt, $userid);
			$data = array(
				"consultlist" => $consultlist
			);
			echo json_encode($data);
		}
	}
	public function bookConsult($sessionid, $userid){
		$sql = "UPDATE consultation SET booked_user = ".$userid.", booking_status = 1 WHERE consult_id = ".$sessionid." ";
		$result = mysqli_query($this->dbConn, $sql);
		$succ = 'success';
		if(!$result){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			return $succ;
		}
	}
	public function getBookedSess($userid){
		$countsql = "SELECT COUNT(*) as total FROM consult_ban WHERE user_id = ".$userid." ";
		$count = mysqli_query($this->dbConn, $countsql);
		$countno = mysqli_fetch_array($count);
		if($countno[0] >= 1){
			$sqldate = "SELECT * FROM consult_ban WHERE user_id = ".$userid." ";
			$res = mysqli_query($this->dbConn, $sqldate);
			if(!$res){
				return ('Error in query: '. mysqli_error());
				echo mysqli_error();
			}else{
				foreach($res as $row){
					$date = $row['datetime'];
				}
				if($date < date("Y-m-d")){
					$sqldel = "DELETE FROM consult_ban WHERE user_id = ".$userid." ";
					mysqli_query($this->dbConn, $sqldel);
				}else{
					$consultlist = "<p class='ban'>You have been banned from booking consultation. Wait until this date (".$date.") to resume this function.</p>";	
				}
			}
		}else{
			$query = "SELECT * FROM ".$this->consultTable." WHERE booked_user = '".$userid."' AND consult_date >= CURDATE() ORDER BY consult_date ASC ";
			$result = $this->getData($query);
			$consultlist = '<ul class="consultdisp">';
			if(!$result){
				$consultlist .= '<p class="noconsult">No sessions booked for this month.</p>';
				$consultlist .= '<button class="nosessbtn">Search Profile to Book Now!</button>';
			}else{
				foreach($result as $val){
					$consultlist .= '<li class="conlist" id="'.$val['consult_id'].'">';
					$consultlist .= '<p>Consultation Date: '.$val['consult_date'].' ';
					$consultlist .= '<br/>';
					$consultlist .= ' Time: ' .$val['start_time'].' to ' .$val['end_time'].' ';
					if($val['booking_status'] == '1'){
						$uid = "SELECT * FROM user WHERE user_id = '".$val['user_id']."' ";
						$user = $this->getData($uid);
						foreach($user as $username){
							$consultlist .= '<br/>';
							$consultlist .= ' Lecturer: '.$username['username'].' ';
						}			
					}
					$consultlist .= '</p>';
					$consultlist .= '</li>';
				}
			}
		}
		$consultlist .= '</ul>';
		return $consultlist;
	}
	public function cancelConsult($reason, $sessionid, $userid){
		$sql = "UPDATE consultation SET booked_user = null, booking_status = 0 WHERE consult_id = ".$sessionid." ";
		mysqli_query($this->dbConn, $sql);
		$sql2 = "SELECT * FROM consultation WHERE consult_id = ".$sessionid." ";
		$result = mysqli_query($this->dbConn, $sql2);
		$sql3 = "SELECT * FROM user WHERE user_id = ".$userid." ";
		$result2 = mysqli_query($this->dbConn, $sql3);
		if(!$result || !$result2){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			foreach($result as $row){
				$lecid = $row['user_id'];
			}
			foreach($result2 as $row2){
				$uname = $row2['username'];
			}
			$sql3 = "INSERT INTO notifications (user_id, notif_content, from_user, notif_date) VALUES (".$lecid.", 'Consultation from ".$uname." has been cancelled due to: ".$reason."', ".$userid.", NOW()) ";
			mysqli_query($this->dbConn, $sql3);
		}
	}
	public function getBooked($userid){
		$query = "SELECT * FROM ".$this->consultTable." WHERE booking_status = 1 AND user_id =".$userid." AND MONTH(consult_date) >= MONTH(CURDATE()) ORDER BY consult_date ASC";
		$result = $this->getData($query);
		$consultlist = '<ul class="consultdisp">';
		if(!$result){
			// return ('Error in query: '. mysqli_error());
			// echo mysqli_error();
			$consultlist .= '<p class="nosess">No booked sessions for this month</p>';
		}else{
			foreach($result as $val){
				$sql = "SELECT * FROM consultation_warning WHERE session_id = ".$val['consult_id']." ";
				$result2 = mysqli_query($this->dbConn, $sql);
				if(!$result2){
					return ('Error in query: '. mysqli_error());
					echo mysqli_error();
				}
				if(mysqli_num_rows($result2)==0){
					$consultlist .= '<li class="booked" id="'.$val['consult_id'].'">';
				}else{
					$consultlist .= '<li class="disabled" id="'.$val['consult_id'].'">';
				}
				$consultlist .= '<p>Consultation Date: '.$val['consult_date'].' ';
				$consultlist .= '<br/>';
				$consultlist .= ' Time: ' .$val['start_time'].' to ' .$val['end_time'].' ';
				$uid = "SELECT * FROM user WHERE user_id = '".$val['booked_user']."' ";
					$user = $this->getData($uid);
					foreach($user as $username){
						$consultlist .= '<br/>';
						$consultlist .= ' Booked By: '.$username['username'].' ';
				}
				$consultlist .= '</p>';
				$consultlist .= '</li>';
			}
		}
		$consultlist .= '</ul>';
		return $consultlist;
	}
	public function getAllBooked(){
		$query = "SELECT * FROM ".$this->consultTable." WHERE booking_status = 1 AND MONTH(consult_date) >= MONTH(CURDATE()) ORDER BY consult_date ASC";
		$result = $this->getData($query);
		$consultlist = '<ul class="consultdisp">';
		if(!$result){
			// return ('Error in query: '. mysqli_error());
			// echo mysqli_error();
			$consultlist .= '<p class="nosess">No booked sessions for this month</p>';
		}else{
			foreach($result as $val){
				$sql = "SELECT * FROM consultation_warning WHERE session_id = ".$val['consult_id']." ";
				$result2 = mysqli_query($this->dbConn, $sql);
				if(!$result2){
					return ('Error in query: '. mysqli_error());
					echo mysqli_error();
				}
				if(mysqli_num_rows($result2)==0){
					$consultlist .= '<li class="booked" id="'.$val['consult_id'].'">';
				}else{
					$consultlist .= '<li class="disabled" id="'.$val['consult_id'].'">';
				}
				$consultlist .= '<p>Consultation Date: '.$val['consult_date'].' ';
				$consultlist .= '<br/>';
				$consultlist .= ' Time: ' .$val['start_time'].' to ' .$val['end_time'].' ';
				$consultlist .= '</p>';
				$consultlist .= '</li>';
			}
		}
		$consultlist .= '</ul>';
		return $consultlist;
	}
	public function reportConsult($sessionid, $userid){
		$sql = "SELECT * FROM consultation WHERE consult_id = ".$sessionid." ";
		$userinfo = mysqli_query($this->dbConn, $sql);
		if(!$userinfo){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			foreach($userinfo as $uinfo){
				$uid = $uinfo['booked_user'];
			}
		}
		$sql2 = "INSERT IGNORE INTO consultation_warning (user_id, session_id) VALUES ($uid, $sessionid)";
		mysqli_query($this->dbConn, $sql2);
		$sql3 = "INSERT IGNORE INTO notifications (user_id, notif_content, from_user, notif_date) VALUES (".$uid.", 'You have received a warning for skipping out on the consultation', ".$userid.", NOW())";
		mysqli_query($this->dbConn, $sql3);
		$sqlban = "SELECT COUNT(*) as total FROM consultation_warning WHERE user_id = ".$uid." ";
		$count = mysqli_query($this->dbConn, $sqlban);
		$countno = mysqli_fetch_array($count);
		if($countno[0] == 3){
			$date=Date('y-m-d', strtotime('+7 days'));
			$sqlin = "INSERT IGNORE INTO consult_ban (user_id, datetime) VALUES ($uid, '$date')";
			mysqli_query($this->dbConn, $sqlin);
			$sqldel = "DELETE FROM consultation_warning WHERE user_id = ".$uid." ";
			mysqli_query($this->dbConn, $sqldel);
			$sql4 = "INSERT IGNORE INTO notifications (user_id, notif_content, from_user, notif_date) VALUES (".$uid.", 'You have been restricted in consultation booking. Check consultation page for more info.', ".$userid.", NOW())";
			mysqli_query($this->dbConn, $sql4);
		}
	}
}
?>