<?php


$ret = (isset($_GET['ret']) ? $_GET['ret'] : null);
include_once 'header.php';
if (isset($_SESSION['u_id'])) {
    include 'includes/dbh.inc.php';
    $sa = $_SESSION['sa'];
    $adm = $_SESSION['admin'];
    if  ($sa != 1 && $adm != 1) {
        header("Location: index.php");
        exit();
    } else {
        $list = array();
        $building = array();
        $floor = array();
        if($_SESSION['sa']==1) {
            $sql = "SELECT floor_id, floor_name, B.building_name, F.building_id FROM floor F
INNER JOIN building B on B.building_id = F.building_id;";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $bid = $row['building_id'];
                $fid = $row['floor_id'];                
                $building[$bid] = $row['building_name'];
                $floor[$fid] = array($row['building_name'],$row['floor_name']);
            }

        } else {
            $uid=$_SESSION['u_id'];
            $sql = "SELECT floor_id, floor_name, B.building_name, F.building_id FROM floor F
INNER JOIN building B on B.building_id = F.building_id
INNER JOIN users_building UB on B.building_id = UB.building_id
INNER JOIN users U ON UB.user_id = U.user_id
WHERE UB.user_id ='$uid';";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $bid = $row['building_id'];
                $fid = $row['floor_id'];                
                $building[$bid] = $row['building_name'];
                $floor[$fid] = array($row['building_name'],$row['floor_name']);
            }

        }
        foreach($building as $bk => $bv) {
            $arr = array();
            $farr = array();
            $rarr = array();
            
            $sql = "SELECT building_name, floor_name, room_name, room_num, room_id FROM room R
INNER JOIN floor F on F.floor_id = R.floor_id
INNER JOIN building B on B.building_id = F.building_id
WHERE B.building_id=$bk;";
            $result = mysqli_query($conn, $sql);

            $row = mysqli_fetch_assoc($result);
            $bname =  $row['building_name'];
            if(isset($row['floor_name'])){            
                $farr = array($row['floor_name'], $row['room_name'], $row['room_id'], $row['room_num']);
                array_push($arr, $farr);

                while ($row = mysqli_fetch_assoc($result)){
                    $farr = array($row['floor_name'], $row['room_name'], $row['room_id'], $row['room_num']);
                    array_push($arr, $farr);
                }
                $list[$bname] = $arr;
            }
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
      <h1>Rooms</h1>
      <div class="container">
	<button id="btn-add" type="submit" class="btn btn-default btn-set-width">Add</button>
	<button id="btn-mod" type="submit" class="btn btn-default btn-set-width">Modify</button>
	<button id="btn-del" type="submit" class="btn btn-default btn-set-width">Delete</button>
      </div>
    </div>
    <div id="add" class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center jumbotron floor-wrapper' style="display: none;">
      <h3>Add New Room</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
    <?php
    foreach($floor as $k => $v) {
        echo "<div class='text-left radio'><label><input type='radio' name='add-rname-s' value='$k'>$v[0]: $v[1]</label></div>";
    }
?>
    
	  <input class="form-control search-query d-flex" name="add-rname-n" type="text" placeholder="Room Name">
	  <input class="form-control search-query d-flex" name="add-rnum-n" type="number" placeholder="Room Number">    
	  <input class="form-control search-query d-flex" name="r_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>
    </div>

    <div id="mod" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Modify A Room</h3>
      <div class="col-sm-6 col-sm-offset-3">	  
	<form class="form-group" action="api/session.php" method="POST">
<?php
foreach($list as $k => $v) {
    foreach($v as $k1 => $v1){
        echo "<div class='text-left radio'><label><input type='radio' name='mod-rname-s' value='$v1[2]'>$k: $v1[0]: $v1[1]: $v1[3]</label></div>";
    }
}
?>
    <input class="form-control search-query d-flex" name="mod-rname-n" type="text" placeholder="New Room Name">
    <input class="form-control search-query d-flex" name="mod-rnum-n" type="number" placeholder="New Room Number">    
	  <input class="form-control search-query d-flex" name="r_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>


    </div>

    <div id="del" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Delete A Room</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
	     <?php
foreach($list as $k => $v) {
    foreach($v as $k1 => $v1){
        echo "<div class='text-left radio'><label><input type='radio' name='mod-rname-s' value='$v1[2]'>$k: $v1[0]: $v1[1], $v1[3]</label></div>";
    }
}
	       ?>                      
	  <input class="form-control search-query d-flex" name="r_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>
    </div>
        <?php
    if($ret=="success"){
        echo "
<div  id='notif' class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<div class='alert alert-success'>
  <strong>Success</strong>
</div>
</div>";
    } else if ($ret=="failure") {
echo "
<div  id='notif'  class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
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
