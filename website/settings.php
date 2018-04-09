
<?php
          
include_once 'header.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
}
?>

    <div class='jumbotron'>
      <div class='row text-center fancy-h'>
        <h1>Settings</h1>
      </div>
    </div>


    <div class="jumbotron">
      <div class="row justify-content-center fancy-p">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center">
	    <h2>Update Information</h2>
	  </div>
	     <form class="form-group" action="includes/update.inc.php" method="POST">

    
	       <input class="form-control search-query d-flex" name="fname" type="text" placeholder="Firstname">
	       <input class="form-control search-query d-flex" name="lname" type="text" placeholder="Lastname">
	       <input class="form-control search-query d-flex" name="email" type="text" placeholder="E-mail">
	       <input class="form-control search-query d-flex" name="zipcode" type="text" placeholder="Zipcode">       
	       <input class="form-control search-query d-flex" name="pwd1" type="password" placeholder="New Password">
	       <input class="form-control search-query d-flex" name="pwd2" type="password" placeholder="Verify New Password">
               <h3>Please enter your current password for security</h3>
	       <input class="form-control search-query d-flex" name="pwd3" type="password" placeholder="Current Password">
	       <button class="btn-info form-control d-flex" type="submit" name="submit">Save Changes</button>
	     </form>

    
	   </div>
      </div>
    </div>


<?php
          
include_once 'footer.php';

?>

