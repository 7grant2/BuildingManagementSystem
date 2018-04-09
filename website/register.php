
<?php
   include_once 'header.php';
?>


    <div class="jumbotron">
      <div class="row text-center fancy-h">
	  <h1>Building Management System</h1>
	</div>
    </div>
    
    <div class="jumbotron">
      <div class="row justify-content-center fancy-p">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center">
	    <h2>register</h2>
	  </div>
	     <form class="form-group" action="includes/signup.inc.php" method="POST">
	       <input class="form-control search-query d-flex" name="fname" type="text" placeholder="Firstname">
	       <input class="form-control search-query d-flex" name="lname" type="text" placeholder="Lastname">
	       <input class="form-control search-query d-flex" name="email" type="text" placeholder="E-mail">
	       <input class="form-control search-query d-flex" name="zipcode" type="text" placeholder="Zipcode">       
	       <input class="form-control search-query d-flex" name="uname" type="text" placeholder="Username">
	       <input class="form-control search-query d-flex" name="pwd1" type="password" placeholder="Password">
	       <input class="form-control search-query d-flex" name="pwd2" type="password" placeholder="Verify Password">	       	             	       
	       <button class="btn-info form-control d-flex" type="submit" name="submit">Sign Up</button>
	     </form>
	   </div>
      </div>
    </div>


<?php
   include_once 'footer.php';
?>
