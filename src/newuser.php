
<?php
session_start();          
include_once 'header.php';

if (isset($_SESSION['u_id'])) {
    include 'includes/dbh.inc.php';
    $sa = $_SESSION['sa'];
    $adm = $_SESSION['admin'];
    if  ($sa != 1 && $adm != 1) {
        header("Location: index.php");
        exit();
    } else {
        $blist = array();
        $building  = $_SESSION['buildings'];
        foreach($building as $bk => $bv) {
            $sql = "SELECT building_name FROM building WHERE building_id=$bv;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            array_push($blist, $row['building_name']);
        }
    }
} else {
        header("Location: index.php");
        exit();

}

?>

    <div class='jumbotron'>
      <div class='row text-center fancy-h'>
        <h1>New User</h1>
      </div>
    </div>


    <div class="jumbotron">
      <div class="row justify-content-center fancy-p">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center">
	    <h2>Information</h2>
	  </div>
	     <form class="form-group" action="includes/newuser.inc.php" method="POST">

    
	       <input class="form-control search-query d-flex" name="fname" type="text" placeholder="Firstname">
	       <input class="form-control search-query d-flex" name="lname" type="text" placeholder="Lastname">
	       <input class="form-control search-query d-flex" name="uname" type="text" placeholder="User Name">          
	       <input class="form-control search-query d-flex" name="email" type="text" placeholder="E-mail">
	       <input class="form-control search-query d-flex" name="zipcode" type="text" placeholder="Zipcode">
	       <input class="form-control search-query d-flex" name="pwd1" type="password" placeholder="New Password">
	       <input class="form-control search-query d-flex" name="pwd2" type="password" placeholder="Verify New Password">
           <div class="checkbox text-center">
           </div>
    
<?php
    echo "<label for='bname'>Select Buildings for New User:</label>";
foreach($blist as $bk => $bv) {
    echo "<div name='bname' class='checkbox text-left'>";    
    echo "<label><input type='checkbox' name='bname[]' value='$bv'/>$bv</label>";
    echo "</div>";
}
 
echo "</label>";
echo "<label for='perm'>Select Permissions for New User</label>";

if($_SESSION['sa'] == 1){
    echo "<div class='radio'><label><input type='radio' name='perm' value='0'>Is Emergency Medical Service</label></div>";
    echo "<div class='radio'><label><input type='radio' name='perm' value='1' >Is Admin</label></div>";
    echo "<div class='radio'><label><input type='radio' name='perm' value='2' checked='checked' >No Permissions</label></div";
} else {
    echo "<div name='bname' class='checkbox text-left'>";    
    echo "<label><input type='checkbox' name='perm' value='1'/>Is Admin</label>";
    echo "</div>";
}
?>
	     
               <h3>Please enter your current password to verify creation of this user</h3>
	       <input class="form-control search-query d-flex" name="pwd3" type="password" placeholder="Current Password">
	       <button class="btn-info form-control d-flex" type="submit" name="submit">Save Changes</button>
	     </form>

    
	   </div>
      </div>
    </div>


<?php
          
include_once 'footer.php';

?>

