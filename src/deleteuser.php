
<?php
session_start();          
include_once 'header.php';

if (isset($_SESSION['u_id'])) {
    include 'includes/dbh.inc.php';
    $sa = $_SESSION['sa'];
    $adm = $_SESSION['admin'];
    if  ($sa != 1) {
        header("Location: index.php");
        exit();
    } else {
        $sql="SELECT U.user_id, U.user_lname, U.user_uname, permission_sa FROM users U
INNER JOIN permission P on P.user_id = U.user_id
WHERE permission_sa <> 1;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $users[$row['user_id']] = array($row['user_uname'], $row['user_lname']);
        }

    }
} else {
        header("Location: index.php");
        exit();

}

?>

    <div class='jumbotron'>
      <div class='row text-center fancy-h'>
        <h1>Delete User</h1>
      </div>
    </div>


    <div class="jumbotron">
      <div class="row justify-content-center fancy-p">
	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-6 col-xs-offset-3">
	  <div class="text-center">
    <h2>ALL DELETES ARE PERMANANT</h2>

	  </div>
	     <form class="form-group" action="api/session.php" method="POST">
<?php
    foreach($users as $k => $v) {
        echo "<div class='text-left radio'><label><input type='radio' name='del-uname-s' value='$k'>$v[0]: $v[1]</label></div>";         
    }
?>
	     
               <h3>Please enter your current password for DELETION of this user</h3>
	       <input class="form-control search-query d-flex" name="u_pwd" type="password" placeholder="Password">
	       <button class="btn-info form-control d-flex" type="submit" name="submit">Save Changes</button>
	     </form>

    
	   </div>
      </div>
    </div>


<?php
          
include_once 'footer.php';

?>

