<?php
include_once 'header.php';
$get = (isset($_GET['ret']) ? $_GET['ret'] : null); 
if (isset($_SESSION['u_id'])) {
    include 'includes/dbh.inc.php';
    $sa = $_SESSION['sa'];
    $adm = $_SESSION['admin'];
    if  ($sa != 1) {
        header("Location: index.php");
        exit();
    } else {
        $list = array();
	$users = array();
        $building = array();
        $sql = "SELECT building_id, building_name FROM building;";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $bn = $row['building_id'];
            $building[$bn]= $row['building_name'];
        }
	       
   	$sql="SELECT U.user_id, U.user_lname, U.user_uname, permission_sa FROM users U
INNER JOIN permission P on P.user_id = U.user_id
WHERE permission_sa <> 1 
AND permission_ems <> 1";
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
    <div>
      <h1>Buildings</h1>
      <div class="container">
	<button id="btn-add" type="submit" class="btn btn-default btn-set-width">Add</button>
	<button id="btn-mod" type="submit" class="btn btn-default btn-set-width">Modify</button>
	<button id="btn-del" type="submit" class="btn btn-default btn-set-width">Delete</button>
      </div>
    </div>
    <div id="add" class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center jumbotron floor-wrapper' style="display: none;">
      <h3>Add New Building</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
	  <input class="form-control search-query d-flex" name="add-bname" type="text" placeholder="Building Name">
<?php
echo "<p>Building Association</p>";
echo "<div class='text-left radio'><label><input type='radio' name='user-s' value='null'>None</label></div>";
foreach($users as $k => $v) {
echo "<div class='text-left radio'><label><input type='radio' name='user-s' value='$k'>$v[0], $v[1]</label></div>"; 
}

?>
	  <input class="form-control search-query d-flex" name="b_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>
    </div>

    <div id="mod" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Modify A Building</h3>
      <div class="col-sm-6 col-sm-offset-3">	  
	<form class="form-group" action="api/session.php" method="POST">
<?php
foreach($building as $k => $v) {
echo "<div class='text-left radio'><label><input type='radio' name='mod-bname-s' value='$k'>$v</label></div>"; 
}
?>
    <input class="form-control search-query d-flex" name="mod-bname" type="text" placeholder="New Building Name">
	  <input class="form-control search-query d-flex" name="b_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>
    </div>

    <div id="del" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Delete A Building</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
	     <?php
foreach($building as $k => $v) {
echo "<div class='text-left radio'><input type='radio' name='del-bname-s' value='$k'>$v</div>"; 
}
	       ?>                      
	  <input class="form-control search-query d-flex" name="b_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>



    
      </div>
    </div>
        <?php
    if($get=="success"){
        echo "
        <div  id='notif' class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<div class='alert alert-success'>
<strong>Success</strong>
</div>
</div>";
    } else if ($get == "failure") {
echo "
    <div  id='notif' class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 alert alert-danger'>
<strong>Failure </strong>
</div>
</div>
";
    }
?>
  </div>

</div>


<?php
    include_once 'footer.php';
?>
