
<?php
session_start();
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

//Displays data relating to building id
/*




 */
/*
foreach ($arr as $key => $value) {
 echo $key;
}
*/

//DISPLAY LATEST SENSOR READINGS
//FORMAT:
//Each building has its own dive
//Within the div, each table is defined per floor/room
//Within each table, the sensors are per row
//Collumn Names: S Name, S ID, Value, Date, Time
function displayData($conn, $uid) {
    //id=>name information
    $building  = array();
    //Get Buildings
    $sql = "SELECT * FROM building WHERE user_id='$uid'; ";
    $result = sqlChecker($sql, $conn);
    if($result != false) {
        while ($row = mysqli_fetch_array($result)){
            $building[$row[building_id]] = $row[building_name];
        }
    } else {
        echo "Something went wrong with Buildings!";
    }

    //New div per building
    foreach ($building as $bkey => $bvalue) {
        $floor = array();
        echo "<div class='jumbotron col-sm-10 col-sm-offset-1'>";
        echo "<div class='center-text col-sm-10 col-sm-offset-1 fancy-c'>";
        echo " <h2 class=''>$bvalue</h2>";
        //GET FLOORS
        $sql = "SELECT * FROM floor WHERE building_id=$bkey;";
        $result = sqlChecker($sql, $conn);
        if($result != false) {
            while ($row = mysqli_fetch_array($result)){
                $floor[$row[floor_id]] = array(
                    $row[floor_name],
                    $row[floor_num]);                    
                    
            }
        } else {
            echo "Something went wrong Floors!";
        }
        
        //GET FLOOR THEN ROOM
        foreach ($floor as $fkey => $fvalue) {
            //GET ROOMS
            $room = array();
            $sql = "SELECT * FROM room WHERE floor_id=$fkey;";
            $result = sqlChecker($sql, $conn);
            if($result != false) {
                while ($row = mysqli_fetch_array($result)){
                    $room[$row[room_id]] = array (
                        $row[room_name],
                        $row[room_num]);
                }
            } else {
                echo "Something went wrong with Rooms!";
            }
            //SET FLOOR TO NAME OR FLOOR NUMBER
            if($fvalue[0] != "") {$floorprint = $fvalue[0];}
            else {$floorprint = $fvalue[1];}
            //CREATE TABLE FOR EACH FLOOR PER ROOM
            foreach ($room as $rkey => $rvalue) {
                //SET ROOM TO NAME OR ROOM NUMBER
                if($rvalue[0] != "") {$roomprint = $rvalue[0];}
                else {$roomprint = $rvalue[1];}                
                if($rvalue == "") {$rvalue = $rkey;}
                    echo "<div class='panel-heading'>Floor: $floorprint<br>Room: $roomprint</div>";
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
                </head>";
                //GET SENSOR PER ROOM
                $sensor = array();
                $sql = "SELECT * FROM sensor WHERE room_id=$rkey;";
                $result = sqlChecker($sql, $conn);
                if($result != false) {
                    while ($row = mysqli_fetch_array($result)){
                        $sensor[$row[sensor_id]] = $row[sensor_type];
                    }
                } else {
                    echo "Something went wrong with Sensors!";
                }
                //GET READING INFORMATION PER SENSOR
                foreach($sensor as $skey => $svalue) {
                    $reading = array();
                    $sql = "SELECT *
FROM reading R WHERE sensor_id=$skey AND reading_date=(SELECT MAX(reading_date) FROM reading) AND reading_time=(SELECT MAX(reading_time) FROM reading)";
                    $result = sqlChecker($sql, $conn);
                    if($result != false) {
                        //Stores each reading as list to sensor_id
                        while ($row = mysqli_fetch_array($result)){
                            $reading[$svalue] = array(
                                $row[sensor_id],
                                $row[reading_value],
                                $row[reading_date],
                                $row[reading_time]);
                        }
                    } else {
                        echo "Something went wrong with readings sensor values<br>";
                    }
                    echo "<tbody>";
                    //LOOP THROUGH EACH SENSOR WITH READING VALUES FOR TABLE
                    foreach ($reading as $rkey => $rval){
                        echo "<tr>";
                        echo "<th scope='row'>$rkey</th>";
                            foreach($rval as $key => $value){
                                echo "<td>$value</td>";
                            }
                        echo "</tr>";
                        /*
                        echo
                            "
                             <tr>
                              <th scope='row'>$rkey</th>
                             ";



                            echo"</tr>";
                        */

                    }
                    echo "</tbody>";
                }            
                echo "</table>";
            }

        }
                    echo "</div>";
        echo "</div>";
        echo "</div>";

    }
 
}

//displayData(3);

//Check if user is logged in    
if(isset($_SESSION['u_id'])) {
    include_once 'dbh.inc.php';
    $uid = $_SESSION['u_id'];
    displayData($conn, $uid);
    exit();
} else {
    header("Location: ../index.php");
    exit();
}

?>


