
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

//DISPLAY LATEST SENSOR READINGS
//FORMAT:
//Each building has its own div
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
            $sql = "SELECT * FROM room WHERE floor_id=$fkey;";
            $result = sqlChecker($sql, $conn);
            if($result != false) {
                while ($row = mysqli_fetch_array($result)){
                    $room[$row[room_id]] = array (
                        $row[room_name],
                        $row[room_num],
                        array() );
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
                //GET SENSOR PER ROOM
                $sensor = array();
                $sql = "SELECT * FROM sensor WHERE room_id=$rkey;";
                $result = sqlChecker($sql, $conn);
                if($result != false) {
                    while ($row = mysqli_fetch_array($result)){
                        $sensor[$rvalue] = array(
                            $row[sensor_type],
                            array());
                        $room[$rkey][2] = $sensor[$row[sensor_id]];
                    }
                } else {
                    echo "Something went wrong with Sensors!";
                }
                //GET READING INFORMATION PER SENSOR
                foreach($sensor as $skey => $svalue) {
                    $reading = array();

                    $sql = "SELECT sensor_id, reading_value, MAX(reading_date) AS reading_date, MAX(reading_time) AS reading_time from reading WHERE sensor_id=$skey;";
                    $result = sqlChecker($sql, $conn);
                    if($result != false) {
                        //Stores each reading as list to sensor_id
                        while ($row = mysqli_fetch_array($result)){
                            $reading[$svalue] = array(
                                $row[sensor_id],
                                $row[reading_value],
                                $row[reading_date],
                                $row[reading_time]);
                            $room[$rkey][2] = $reading[$svalue];
                            $room[$rkey][3] = $svalue;
                            
                        }
                    } else {
                        echo "Something went wrong with readings sensor values<br>";
                    }
                    
                    //end of sensor loop
                }
  




                }
           
            //sort rooms here by -1
            //  print $rkey;
            
            //loop through each room 
            foreach($room as $rkey => $rvalue) {
                //loop thorugh each sensor
                foreach($rvalue as $rkey => $rvalue) {
                    //if sensor type is capacity
                    if($rvalue[0] == "CAPACITY"){
                        //store value and compare to next room
                        
                        
                    }
                }
                //check sensors here
                $temp = $rkey;
            }

            //end of room loop
            }

            foreach ($room as $rkey => $rvalue) {
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
                </thead>";

                echo "<tbody>";
                    echo "<tr>";
                    echo "<th scope='row'>$rvalue[3]</th>";
                    foreach ($rvalue[2] as $rkey => $rvalue){
                        echo  "<td>$rvalue</td>";
                    }
                    /**
                    for(int i = 1; i < 4; i++){
                        echo "<td>$rvalue[1]</td>";
                        }*/

                echo "</tbody>";
                echo "</table>";
                
            //end of floor loop
        }
    
                    echo "</div>";
        echo "</div>";
        echo "</div>";
        //end of building loop
    }
    //end of function
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
