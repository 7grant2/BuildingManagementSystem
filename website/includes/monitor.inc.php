
<?php
//Check sql if data is in table
function sqlChecker($sql, $conn)
{
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0) 
    {
        // echo "returning result<br>";
        return $result;
    } else {
        //echo "returning false<br>";
        return false;
    }
}

//DISPLAY LATEST SENSOR READINGS
//FORMAT:
//Each building has its own div
//Within the div, each table is defined per floor/room
//Within each table, the sensors are per row
//Collumn Names: S Name, S ID, Value, Date, Time
function displayData($conn, $uid) {
    //id=>name information
    $building  = $_SESSION['buildings'];
    //Get Buildings
    //New div per building
    foreach ($building as $bkey => $bvalue) {
        $floor = array();
        $address = array();
        
        $sql = "SELECT building_name FROM building WHERE building_id=$bvalue;";
        $result = sqlChecker($sql,$conn);
	if(!$result){
	   break;
	}
        $row = mysqli_fetch_assoc($result);
        $bname = $row['building_name'];

        $sql = "SELECT address_street, address_city, address_state, address_zip FROM address WHERE building_id=$bvalue;";
        $result = sqlChecker($sql,$conn);
        $row = mysqli_fetch_assoc($result);
        $address = array($row['address_street'], $row['address_city'], $row['address_state'], $row['address_zip']);

        echo "<div class=' fancy-c  col-m-10 col-m-offset-1 col-lg-8 text-center col-lg-offset-2'>";
        echo "<h2 class=''>$bname</h2>";
        echo "<p>$address[0], $address[1], $address[2], $address[3]</p> ";
        echo "<div class='col-sm-10 text-center jumbotron col-sm-offset-1'>";        

        //GET FLOORS
        $sql = "SELECT * FROM floor WHERE building_id=$bvalue;";
        $result = sqlChecker($sql, $conn);
        if($result != false) {
            while ($row = mysqli_fetch_array($result)){
                $floor[$row['floor_id']] = array(
                    $row['floor_name'],
                    $row['floor_num']);                    
                    
            }
        } else {
            echo "There are no floors...<br>";
        }
        
        //GET FLOOR THEN ROOM
        foreach ($floor as $fkey => $fvalue) {
            //SET FLOOR TO NAME OR FLOOR NUMBER
            if($fvalue[0] != "") {$floorprint = $fvalue[0];}
            else {$floorprint = $fvalue[1];}
            echo "<div class='floor-wrapper container'>";
            echo "<h3>$floorprint</h3>";            
            echo "<div class='text-left col-md-10 col-md-offset-1'>";

            //GET ROOMS
            $room = array();
            $sql = "SELECT * FROM room WHERE floor_id=$fkey;";
            $result = sqlChecker($sql, $conn);
            if($result != false) {
                while ($row = mysqli_fetch_array($result)){
                    $room[$row['room_id']] = array (
                        $row['room_name'],
                        $row['room_num']);
                }
            } else {
                echo "<p>No rooms on this floor<br></p>";
            }

            //CREATE TABLE FOR EACH FLOOR PER ROOM
            foreach ($room as $rkey => $rvalue) {
                //SET ROOM TO NAME OR ROOM NUMBER
                if($rvalue[0] != "") {$roomprint = $rvalue[0];}
                else {$roomprint = $rvalue[1];}                
                if($rvalue == "") {$rvalue = $rkey;}
                //Init flag of smoke to 0;
                $sflag = 0;                
                echo "<div class='room-wrapper'>";
                echo "<div class='panel-heading'>Room: $roomprint</div>";
                echo "<table class='table'>";
                echo"
                <thead>
                 <tr>
                   <th>Sensor Name</th>
                   <th>Sensor ID</th>
                   <th>Value</th>
                   <th>Date</th>
                   <th>Time</th>
                </tr>
                </thead>";
                //GET SENSOR PER ROOM
                $sensor = array();
                $sql = "SELECT * FROM sensor WHERE room_id=$rkey;";
                $result = sqlChecker($sql, $conn);
                if($result != false) {
                    while ($row = mysqli_fetch_array($result)){
                        $sensor[$row['sensor_id']] = $row['sensor_type'];
                    }
                } else {
                    echo "<p>There are no Sensors in this room.<p>";
                }
                //GET READING INFORMATION PER SENSOR
                foreach($sensor as $skey => $svalue) {
                    $reading = array();
 		    $sql = "SELECT sensor_name, reading_value, reading_date, reading_time from reading R, sensor S WHERE S.sensor_id=$skey AND R.sensor_id=$skey AND reading_date = (SELECT MAX(reading_date) from reading RR, sensor SS WHERE SS.sensor_id=$skey AND RR.sensor_id=$skey) AND reading_time = (SELECT MAX(reading_time) from reading R3, sensor S3 WHERE S3.sensor_id=$skey AND R3.sensor_id=$skey);"; 
                    $result = sqlChecker($sql, $conn);
                    if($result != false) {
                        //Stores each reading as list to sensor_id
                        while ($row = mysqli_fetch_array($result)){
                            $reading[$svalue] = array(
                                $row['sensor_name'],
                                $row['reading_value'],
                                $row['reading_date'],
                                $row['reading_time']);
                        }
                    } else {
                        //echo "Something went wrong with readings sensor values<br>";
			$sql = "SELECT sensor_name FROM sensor S WHERE S.sensor_id=$skey;";
			$result = sqlChecker($sql, $conn);
			$row = mysqli_fetch_array($result);
			$reading[$svalue] = array(
				$row['sensor_name'],
				"No Readings",
				"",
				""); 
                    }
                    echo "<tbody>";
                    //LOOP THROUGH EACH SENSOR WITH READING VALUES FOR TABLE
                    foreach ($reading as $rkey => $rval){
                        if($rkey == "SMOKE" && $rval[1] >= 1) {
                            echo "<tr class='em-wrapper'>";
                            echo "<th scope='row'>$rkey</th>";
                            foreach($rval as $key => $value){
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<th scope='row'>$rkey</th>";
                            foreach($rval as $key => $value){
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }

                    }
                    echo "</tbody>";
                }            
                echo "</table>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";

    }
    echo "</div>";
    echo "</div>";        

}

//displayData(3);

//Check if user is logged in    
if(isset($_SESSION['u_id'])) {
    include_once 'dbh.inc.php';
    $uid = $_SESSION['u_id'];
    displayData($conn, $uid);

} else {
    header("Location: ../index.php");
    exit();
}

?>


