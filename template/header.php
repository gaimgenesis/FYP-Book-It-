<div class="header">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-6">
      <a href="homepage.php">
      <img src="uploads/logo.PNG" alt="Book It" height="30"></a>
    </div>
    <div class="col">
      <div class="dropdown">
		  <button class="dropbtn">
      <?php 
        include('backend/users.php');
        $user = new Users();
        $uinfo = $user->getUserinfo($_SESSION['userid']);
        foreach($uinfo as $row){
          echo $row['username'];
        }
      ?></button>
		  <div class="dropdown-content">
		  <a href="uprofile.php">Profile</a>
      <?php
      if($_SESSION['userrole'] != "2"){
        echo '<a href="notifications.php">Notifications</a>';
      }
		  ?>
		  </div>
		</div>
    </div>
  </div>
</div>