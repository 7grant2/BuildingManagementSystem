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
        $room = array();
	$building = array();
   	if($_SESSION['sa']==1) {
            $sql = "SELECT R.room_name, R.room_id, F.floor_num, F.floor_id, F.floor_name, B.building_name, B.building_id, sensor_id, sensor_name FROM sensor S
RIGHT JOIN room R on R.room_id = S.room_id
INNER JOIN floor F on F.floor_id = R.floor_id
INNER JOIN building B on B.building_id = F.building_id;";            
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $bid = $row['building_id'];                
                $rid = $row['room_id'];     
                $building[$bid] = $row['building_name'];
                $room[$rid] = array($row['building_name'], $row['floor_name'], $row['floor_num'], $row['room_name']); 
            }
        } else {
            $uid=$_SESSION['u_id'];
            $sql = "SELECT R.room_name, R.room_id, F.floor_id, F.floor_num, F.floor_name, B.building_name, F.building_id, sensor_id, sensor_name FROM sensor S
RIGHT JOIN room R on S.room_id = R.room_id
INNER JOIN floor F on F.floor_id = R.floor_id
INNER JOIN building B on B.building_id = F.building_id
INNER JOIN users_building UB on B.building_id = UB.building_id
INNER JOIN users U ON UB.user_id = U.user_id
WHERE UB.user_id ='$uid';";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $bid = $row['building_id'];
                $fid = $row['floor_id'];                
                $rid = $row['room_id'];                
                $building[$bid] = $row['building_name'];
                $room[$rid] = array($row['building_name'], $row['floor_name'], $row['floor_num'], $row['room_name']);
            }
   }
        foreach($building as $bk => $bv) {
            $arr = array();
            $farr = array();
            $sql = "SELECT B.building_name, F.floor_name, R.room_id, R.room_name,R.room_num, sensor_type, sensor_id, sensor_name FROM sensor S
INNER JOIN room R on R.room_id = S.room_id
INNER JOIN floor F on F.floor_id = R.floor_id
INNER JOIN building B on B.building_id = F.building_id
WHERE B.building_id='$bk';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $bname =  $row['building_name'];
            if(isset($row['building_name'])){
                $farr = array($row['sensor_name'],$row['floor_name'], $row['room_name'], $row['room_id'], $row['room_num'], $row['sensor_type'], $row['sensor_id'], $row['sensor_name']);                
                array_push($arr, $farr);
                while ($row = mysqli_fetch_assoc($result)){
                    $farr = array($row['sensor_name'], $row['floor_name'],$row['room_name'], $row['room_id'], $row['room_num'], $row['sensor_type'], $row['sensor_id'], $row['sensor_name']);                
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
      <h1>Sensors</h1>
      <div class="container">
	<button id="btn-add" type="submit" class="btn btn-default btn-set-width">Add</button>
	<button id="btn-mod" type="submit" class="btn btn-default btn-set-width">Modify</button>
	<button id="btn-del" type="submit" class="btn btn-default btn-set-width">Delete</button>
      </div>
    </div>
    <div id="add" class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 text-center jumbotron floor-wrapper' style="display: none;">
      <h3>Add New Sensor</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
    <?php
    foreach($room as $k => $v) {
        echo "<div class='text-left radio'><label><input type='radio' name='add-sname-s' value='$k'>$v[0]: $v[1]: $v[2]: $v[3]</label></div>";
    }
?>
   
	  <input class="form-control search-query d-flex" name="add-snum-n" type="number" placeholder="Sensor Number">    
<div class='text-left radio'><label><input type='radio' name='add-stype' value='SMOKE'>SMOKE</label></div>
<div class='text-left radio'><label><input type='radio' name='add-stype' value='CAPACITY'>CAPACITY</label></div>
<div class='text-left radio'><label><input type='radio' name='add-stype' value='MOTION'>MOTION</label></div>

<div class='text-left radio'><label><input type='radio' name='add-stype' value='METAL'>METAL</label></div>        
<div class='text-left radio'><label><input type='radio' name='add-stype' value='RFID'>RFID</label></div>        
	  <input class="form-control search-query d-flex" name="s_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>
    </div>

    <div id="mod" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Modify A Sensor</h3>
      <div class="col-sm-6 col-sm-offset-3">	  
	<form class="form-group" action="api/session.php" method="POST">
<?php
foreach($list as $k => $v) {
    foreach($v as $k1 => $v1){
        echo "<div class='text-left radio'><label><input type='radio' name='mod-sname-s' value='$v1[6]'>$k: $v1[1]: $v1[2]: $v1[3]: $v1[5]: $v1[0]</label></div>";
    }
}
?>
    <input class="form-control search-query d-flex" name="mod-snum-n" type="number" placeholder="New Sensor Number">
    <div class='text-left radio'><label><input type='radio' name='mod-stype' value='SMOKE'>SMOKE</label></div>
<div class='text-left radio'><label><input type='radio' name='mod-stype' value='CAPACITY'>CAPACITY</label></div>
<div class='text-left radio'><label><input type='radio' name='mod-stype' value='MOTION'>MOTION</label></div>
<div class='text-left radio'><label><input type='radio' name='mod-stype' value='RFID'>RFID</label></div>        


	  <input class="form-control search-query d-flex" name="s_pwd" type="password" placeholder="Password">    	             	       	    
	  <button class="btn-info form-control d-flex" type="submit" name="submit">Submit</button>
	</form>
      </div>


    </div>

    <div id="del" class='col-sm-10 text-center jumbotron floor-wrapper col-sm-offset-1' style="display: none;">
      <h3>Delete A Sensor</h3>
      <div class="col-sm-6 col-sm-offset-3">
	<form class="form-group" action="api/session.php" method="POST">
	     <?php
foreach($list as $k => $v) {
    foreach($v as $k1 => $v1){
        echo "<div class='text-left radio'><label><input type='radio' name='mod-sname-s' value='$v1[6]'>$k: $v1[1]: $v1[2]: $v1[3]: $v1[5]: $v1[0]</label></div>";
    }
}
	       ?>                      
	  <input class="form-control search-query d-flex" name="s_pwd" type="password" placeholder="Password">    	             	       	    
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
