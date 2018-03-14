<?php
  include_once 'header.php';
  $login  = (isset($_GET['query_age']) ? $_GET['query_age'] : null);
?>

    <div class="jumbotron">
      <div class="row text-center fancy-h">
	  <h1>Building Management System</h1>
	  </div>
    </div>
    
    <div class="jumbotron">
      <div class="row justify-content-center">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center fancy-p">
	    <h2>LOGIN</h2>
	  </div>
	     <form class="form-group" action="includes/login.inc.php" name="submit" method="POST">
	       <input class="form-control search-query d-flex field-color" name="uid" type="text" placeholder="Username">
   	       <input class="form-control d-flex field-color" type="password" name="pwd" placeholder="Password">
	       <button class="btn btn-info form-control d-flex" type="submit" name="submit">Login</button>
	     </form>
	     <div class="text-center">
		 <a href="register.php">Register</a> - 
		 <a href="#">Forgot Password</a>
	     </div> 
        <?php    
    if($login == "error" || $login == "empty"){
echo "
<div class='alert alert-danger'>
  <strong>Login Failed </strong>
</div>
</div>
";
    }
?>          
 
	   </div>
     </div>
  
    </div>
    
<?php
    include_once 'footer.php';
?>
      
