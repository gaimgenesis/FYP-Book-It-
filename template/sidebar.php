<div id="mySidenav" class="sidenav">
	<a href="#"><span onclick="myFunction(this); toggle(this);"><i class="material-icons">menu</i><span class="icon-text">Menu</span></a><br/>
 	<a href="materials.php"><span><i class="material-icons">library_books</i><span class="icon-text">Materials</span></a><br/>
	<a href="search.php"><span><i class="material-icons">search</i><span class="icon-text">People</span></a><br/>
	<a href="messageroom.php"><span><i class="material-icons">speaker_notes</i><span class="icon-text">Messages</span></a><br/>
	<?php
		if($_SESSION['userrole'] == "1"){
			echo '<a href="consultations.php"><span><i class="material-icons">book_online</i><span class="icon-text">Consultations</span></a><br/>';
		}else{
			echo '<a href="consultlist.php"><span><i class="material-icons">fact_check</i><span class="icon-text">Consultations</span></a><br/>';
		}
	?>
	<a href="assignmentdropoff.php"><span><i class="material-icons">assignment_returned</i><span class="icon-text">Submissions</span></a><br/>
	<a href="quiz.php"><span><i class="material-icons">videogame_asset</i><span class="icon-text">Quiz</span></a><br/>
	<a href="backend/logout.php" class="logout"><span><i class="material-icons">login</i><span class="icon-text">Logout</span></a><br/>	
</div>