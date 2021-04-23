<?php
class Chat{
	private $host = 'localhost';
	private $user = 'root';
	private $pass = "";
	private $db = "book_it";
	private $chatTable = 'chat';
	private $chatUsersTable = 'chat_users';
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
			die('Error in query: '. mysqli_error());
		}
		$data = array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$data[] = $row;
		}
		return $data;
	}	
	public function getUserDetails($uid){
		$sql = "SELECT * FROM chat_session
		WHERE user_id = '$uid'";
		$result = mysqli_query($this->dbConn, $sql);
		$data = array();
		if(!$result){
			return $data;
		}else{
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$data[] = $row;
			}
		}
		return $data;
	}
	public function getUsers($uid){
		$sql = "SELECT * FROM user
		WHERE user_id = '$uid'";
		return $this->getData($sql);
	}
	public function chatUsers($uid){
		$query = "SELECT * FROM ".$this->chatUsersTable." 
		WHERE user_sender_id = '$uid' ORDER BY last_message_sent DESC";
		$result = mysqli_query($this->dbConn, $query);
		$data = array();
		if(!$result){
			$query2 = "SELECT * FROM ".$this->chatUsersTable." 
			WHERE user_receiver_id = '$uid' ORDER BY last_message_sent DESC";
			$result2 = mysqli_query($this->dbConn, $query2);
			if(!$result2){
				return $data;
			}else{
				while($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
					$data[] = $row;
				}
				array_push($data, "true");
				return $data;
			}
		}else{
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
				$data[] = $row;
			}
		}
		return $data;
	}
	public function insertChat($to_user_id, $from, $message){
		$sql = "INSERT INTO ".$this->chatTable."
		(reciever_userid, sender_userid, message, status)
		VALUES ('".$to_user_id."', '".$from."', '".$message."', '0')";
		$result = mysqli_query($this->dbConn, $sql);
		if(!$result){
			return ('Error in query: '. mysqli_error());
			echo mysqli_error();
		}else{
			$sql2 = "INSERT IGNORE INTO chat_users (user_sender_id, user_receiver_id, last_message_sent)
			VALUES ('".$from."', '".$to_user_id."', NOW())";
			$result2 = mysqli_query($this->dbConn, $sql2);
			$sql3 = "INSERT IGNORE INTO chat_users (user_sender_id, user_receiver_id, last_message_sent)
			VALUES ('".$to_user_id."', '".$from."', NOW())";
			mysqli_query($this->dbConn, $sql3);
			if(!$result2){
				return ('Error in query: '. mysqli_error());
				echo mysqli_error();
			} else{
				$conversation = $this->getUserChat($from, $to_user_id);
				$data = array(
					"conversation" => $conversation
				);
				echo json_encode($data);
			}
			$sqlUpdateSess = "UPDATE chat_users
			SET last_message_sent = NOW()
			WHERE user_sender_id = '".$from."' AND user_receiver_id = '".$to_user_id."' ";
			mysqli_query($this->dbConn, $sqlUpdateSess);
			$sqlUpdateSess2 = "UPDATE chat_users
			SET last_message_sent = NOW()
			WHERE user_sender_id = '".$to_user_id."' AND user_receiver_id = '".$from."' ";
			mysqli_query($this->dbConn, $sqlUpdateSess2);
		}
		$sqlUpdate = "UPDATE chat_session
		SET session = '".$to_user_id."'
		WHERE user_id = '".$from."'";
		mysqli_query($this->dbConn, $sqlUpdate);
	}
	public function getUserChat($from, $to_user_id){
		$query = "SELECT * FROM ".$this->chatTable."
		WHERE (sender_userid = '".$from."'
		AND reciever_userid = '".$to_user_id."')
		OR (sender_userid = '".$to_user_id."'
		AND reciever_userid = '".$from."')
		ORDER BY timestamp ASC";
		$userChat = $this->getData($query);
		$conversation = '<ul>';
		if(!$userChat){
			$conversation .= '<p class="nomessage">No messages yet. Start a conversation now!</p>';
			$conversation .= '<button class="gotoprof">Profile Search</button>';
		}else{
			foreach($userChat as $chat){
				$user_name = '';
				if($chat["sender_userid"] == $from){
					$conversation .= '<li class = "sent">';
				}else{
					$conversation .= '<li class = "replies">';
				}
				$conversation .= '<p>'.$chat["timestamp"].'<br/><br/>';
				$conversation .= ' '.$chat["message"].'</p>';
				$conversation .= '</li>';
			}
		}
		$conversation .= '</ul>';
		return $conversation;
	}
	public function showUserChat($from, $to_user_id){
		$userDetails = $this->getUsers($to_user_id);
		foreach ($userDetails as $user){
			$profile = '<p id="userid'.$to_user_id.'" class="profilelink"><a href="profile.php?id='.$user['user_id'].'">'.$user['username'].'</a></p>';
		}
		//get user convo
		$conversation = $this->getUserChat($from, $to_user_id);

		$sqlUpdate = "UPDATE chat_session
		SET session = '".$to_user_id."'
		WHERE user_id = '".$from."'";
		mysqli_query($this->dbConn, $sqlUpdate);
		$data = array(
			"conversation" => $conversation,
			"profile" => $profile
		);
		echo json_encode($data);
	}
	public function getList($user){
		$result = '<p> Hello World. </p>';
		return $result;
	}
}
?>