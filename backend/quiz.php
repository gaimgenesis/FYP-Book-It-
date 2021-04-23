<?php
class Quiz{
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
    public function getQuizList($cid, $uid){
        $sql = "SELECT * FROM quiz WHERE user_id = ".$uid." AND course_id = ".$cid." ";
        $result = $this->getData($sql);
        $disp = "<ul class='courquiz'>";
        if(!$result){
            $disp .= "<p class='noquiz'>No quizzes created yet</p>";
        }else{
            foreach($result as $row){
                $disp .= "<li class='quizmgmt' id='".$row['quiz_id']."'>".$row['quiz_name']."</li>";
            }
        }
        $disp .= "</ul>";
        return $disp;
    }
    public function getQuizListStd($cid){
        $sql = "SELECT * FROM quiz WHERE course_id = ".$cid." ";
        $result = $this->getData($sql);
        $disp = "<ul class='courquiz'>";
        if(!$result){
            $disp .= "<p class='noquiz'>No quizzes created yet</p>";
        }else{
            foreach($result as $row){
                $disp .= "<li class='playquiz' id='".$row['quiz_id']."'>".$row['quiz_name']."</li>";
            }
        }
        $disp .= "</ul>";
        return $disp;
    }
    public function createQuiz($cid, $qname, $uid){
        $sql = "INSERT INTO quiz (quiz_name, user_id, course_id) VALUES ('".$qname."', ".$uid.", ".$cid.") ";
        $result = mysqli_query($this->dbConn, $sql);
        $end = "";
        if(!$result){
            return ('Error in query: '. mysqli_error());
			echo mysqli_error();
        }else{
            $quizid = mysqli_insert_id($this->dbConn);
            $end = "<input type='hidden' class='quizid' name='quizid' value='".$quizid."'/>";
        }
        return $end;
    }
    public function createQuestion($qname, $ansarr, $optarr, $qid){
        $sql = "INSERT INTO quiz_question (quiz_question, quiz_id_fk) VALUES ('".$qname."', ".$qid.") ";
        $result = mysqli_query($this->dbConn, $sql);
        if(!$result){
            return ('Error in query: '. mysqli_error());
			echo mysqli_error();
        }else{
            $quizid = mysqli_insert_id($this->dbConn);
            for($i = 0; $i<sizeof($ansarr); $i++){
                $sql2 = "INSERT INTO quiz_answer (quiz_answer, correct_answer, quiz_question_id) VALUES ('".$ansarr[$i]."', ".$optarr[$i].", ".$quizid.") ";
                $result2 = mysqli_query($this->dbConn, $sql2);
                if(!$result2){
                    return ('Error in query: '. mysqli_error());
			        echo mysqli_error();
                }else{
                    $res = "Success";
                }
            }
        }
        return $res;
    }
    public function countQuestion($qid){
        $sql = "SELECT COUNT(*) as total FROM quiz_question WHERE quiz_id_fk = ".$qid." ";
        $result = mysqli_query($this->dbConn, $sql);
        if(!$result){
            $count = "<p>(No question(s) created).</p>";
        }else{
            $data = mysqli_fetch_assoc($result);
            $count = "<p>(".$data["total"]." question(s) created).</p>";
        }
        return $count;
    }
    public function showQuiz($qid, $limitone, $limittwo, $score, $uid){
        $sql = "SELECT * FROM quiz_question WHERE quiz_id_fk = ".$qid." LIMIT ".$limitone.", ".$limittwo." ";
        $result = mysqli_query($this->dbConn, $sql);
        $count = "";
        if (mysqli_num_rows($result)==0){
            $count .= $this->getScores($score, $uid, $qid, $limitone);
        }
        if(!$result){
            $count = "<p>(No question(s) created).</p>";
            $count .= $sql;
        }else{
            foreach($result as $row){
                $count = "<h2 class='questionid' id='".$qid."'>Question: ".$row['quiz_question']."</h2><br/>";
                $count .= "<p class='limitone' hidden>".$limitone."</p>";
                $count .= "<p class='limittwo' hidden>".$limittwo."</p>";
                $questid = $row['quiz_question_id'];
            }
            if(isset($questid)){
                $sql2 = "SELECT * FROM quiz_answer WHERE quiz_question_id = ".$questid." ";
                $result2 = mysqli_query($this->dbConn, $sql2);
                $count .= "<ul>";
                if(!$result2){
                    $count .= "<p>No answers</p>";
                }else{
                    foreach($result2 as $row2){
                        $count .= "<li class='ansli' id='".$row2['correct_answer']."'>".$row2['quiz_answer']."</li>";
                    }
                }
                $count .= "</ul>";
                $count .= "<button class='next' id='".$score."'>Next Question</button>";
            }
        }
        return $count;
    }
    public function getScores($score, $uid, $qid, $limitone){
        $sql = "INSERT INTO quiz_score (user_id, quiz_id, score, quiz_date) VALUES (".$uid.", ".$qid.", ".$score.", NOW())";
        $result = mysqli_query($this->dbConn, $sql);
        $count = "";
        if(!$result){
            $count .= "Error";
        }else{
            $count .= "<h1 style='text-align:center'>User Score</h1><br/><br/>";
            $count .= "<h3 style='text-align:center'>You got ".$score."/".$limitone." questions correct.</h3>";
            $count .= "<button class='back'>Back to Quiz List</button>";
        }
        return $count;
    }
    public function getQuizQuestCount($qid){
        $sql = "SELECT COUNT(*) as count FROM quiz_question WHERE quiz_id_fk = ".$qid." ";
        return $this->getData($sql);
    }
    public function getQuizName($qid){
        $sql = "SELECT * FROM quiz WHERE quiz_id = ".$qid." ";
        return $this->getData($sql);
    }
    public function getScore($qid){
        $sql = "SELECT * FROM quiz_score WHERE quiz_id = ".$qid." ";
        $result = mysqli_query($this->dbConn, $sql);
        $count = "";
        if(!$result){
            $count .= "Error";
        }else{
            $count .= "<table class='scoretable'><tr><th>Name</th><th>Score</th><th>Date</th></tr>";
            foreach($result as $row){
                $sql2 = "SELECT * FROM user WHERE user_id = ".$row['user_id']." ";
                $result2 = mysqli_query($this->dbConn, $sql2);
                if(!$result2){
                    $count .= "Error";
                }else{
                    foreach($result2 as $row2){
                        $count .= "<tr><td>".$row2['username']."</td><td>".$row['score']."</td><td>".$row['quiz_date']."</td></tr>";                        
                    }
                }
            }
            $count .= "</table>";
        }
        return $count;
    }
}
?>