<?php
session_start();



  ?>

<!DOCTYPE html>
<html>
  <header>
    <title>Building Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <nav class="navbar navbar-default nav-color">
      <div class="container-fluid">

	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="index.php"><img class="img-responsive imgfit " src="img/bms.png"/></a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	  <ul class="nav navbar-nav">
	    <li><a  href='index.php'>Home</a></li>	    
	    <?php
    if (!isset($_SESSION['u_id'])) {
    } else {
              echo "<li><a href='monitor.php'>Monitor</a></li>";
              if ($_SESSION['sa'] == 1) {
                  echo "<li><a href='building.php'>Buildings</a></li>";
              }
              if ($_SESSION['sa'] == 1 || $_SESSION['admin'] == 1) {
                 echo "<li><a href='floor.php'>Floors</a></li>";
                 echo "<li><a href='room.php'>Rooms</a></li>";
                 echo "<li><a href='sensor.php'>Sensors</a></li>";
                 echo "<li><a href='newuser.php'>New User</a></li>"; 

              }
              if ($_SESSION['sa'] == 1) {
                  echo "<li><a href='deleteuser.php'>Delete User</a></li>";
              }              
    }
	      ?>
			
	  </ul>
	  <ul class="nav navbar-nav navbar-right">
	    <?php
    if (isset($_SESSION['u_id'])) {
        echo "<li><a href='settings.php'>", $_SESSION['u_uname'], "</a></li>";

        echo "<li>
	      <form class='btn btn-pad' action='includes/logout.inc.php' name='submit' method='POST'>
		<button type='submit' name='submit'  class='btn-link'>Logout</button>
	      </form>
	    </li>";
    } else {
         echo "<li><a href='login.php'>Login</a></li>";
         echo "<li><a href='register.php'>Register</a></li>";         
    }
?>
	  </ul>
	</div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
  </header>
  <body>
