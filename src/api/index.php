
<?php
$reqmethod = $_SERVER['REQUEST_METHOD'];
/*

http://localhost:8889/BuildingManagementSystem/build/api/index.php?sensorname=101&date=2018/08/24&time=08:24:22&metric=2&username=root&password=root

*/

//ensure users can't push data that is not in their own user
// will return sensor_id if successful
function checkSensors($conn, $user, $sname) {
    $sql = "SELECT sensor_id FROM sensor S
INNER JOIN room R ON R.room_id = S.room_id
INNER JOIN floor F ON F.floor_id = R.floor_id
INNER JOIN building B ON B.building_id = F.building_id
INNER JOIN users_building UB on UB.building_id = B.building_id
INNER JOIN users U ON UB.user_id = U.user_id
WHERE U.user_uname = '$user'
AND S.sensor_name = '$sname';";
    //echo "$sql";
    $result = mysqli_query($conn,  $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck == 1) {
        return mysqli_fetch_array($result);
    } else {
        return false;
    }
}

function pushData($conn, $sid, $date, $time, $metric) {
        $sql = "INSERT INTO reading(sensor_id, reading_date, reading_time, reading_value) VALUES ($sid, '$date', '$time', $metric);";
        $result = mysqli_query($conn, $sql);
        if($result) {
            return true;
        } else {
            return false;
        }
}

function alertUser($conn, $user, $sname) {
    //Get user email and zip code to get all EMS nearby.
    $sql = "SELECT floor_num, floor_name, building_name, address_street, address_city, address_state, address_zip, room_name, room_num
FROM sensor S
INNER JOIN room R on R.room_id = S.room_id
INNER JOIN floor F on F.floor_id = R.floor_id
INNER JOIN building B on B.building_id = F.building_id
INNER JOIN address A on A.building_id = B.building_id
WHERE S.sensor_name = $sname;
";
    $result = mysqli_query($conn,  $sql);
    $row = mysqli_fetch_assoc($result);
    $user_zip = $row['address_zip']; 
    $msg = 'SMOKE ALERT' . "\n"
        . 'Building: ' . $row['building_name'] .  "\n"
        . 'Address: ' . $row['address_street'] . " " . $row['address_city'] . "\n"
        . $row['address_state'] . " " . $row['address_zip'] .  "\n"        
        . 'Floor Name: ' . $row['floor_name'] . "\n"
        . 'Floor Number: ' . $row['floor_num'] . "\n"        
        . 'Room Name: ' . $row['room_name'] . "\n"
        . 'Room Number: ' . $row['room_num'] . "\n";
    $msg = wordwrap($msg,70);
    $emails = array();
    //Select email of user pushing sensor
    $sql = "SELECT user_email, user_zip FROM users WHERE user_uname='$user';";
    $result = mysqli_query($conn,  $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck == 0) {
        return false;
    } else {
        $row = mysqli_fetch_array($result);
        array_push($emails, $row['user_email']);        
        $zip = $row['user_zip'];
	//get ems users for this locations
        $sql = "SELECT U.user_email FROM users U
INNER JOIN permission P ON P.user_id = U.user_id
WHERE U.user_zip = $user_zip
AND P.permission_ems = 1;";
        $result = mysqli_query($conn,  $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            return false;
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($emails, $row['user_email']);
            }
            //SEND EMAIL TO ALL USERS
            foreach ($emails as $ekey => $eval) {
		try {
                    mail($eval, 'SMOKE ALERT', $msg);
		} catch (Exception $e) {
		    echo "mail failed";
		}
            }
        }
    }    
}

if($reqmethod == "GET") {

} else if ($reqmethod == "POST") {
    if (isset($_REQUEST['sensorname']) && isset($_REQUEST['date']) && isset($_REQUEST['time']) && isset($_REQUEST['metric']) && isset($_REQUEST['username']) && isset($_REQUEST['password'])){

        include '../includes/dbh.inc.php';        
        $uid = mysqli_real_escape_string($conn, $_REQUEST['username']);
        $pwd = mysqli_real_escape_string($conn, $_REQUEST['password']);
        $sname = mysqli_real_escape_string($conn, $_REQUEST['sensorname']);
        $date = mysqli_real_escape_string($conn, $_REQUEST['date']);
        $time = mysqli_real_escape_string($conn, $_REQUEST['time']);
        $metric = mysqli_real_escape_string($conn, $_REQUEST['metric']);
        //Error handlers
        //Check if inputs are empty
        if (empty($uid) || empty($pwd)) {
            echo "error 400";            
            http_response_code(400);
        } else {
            //Does user exist in DB
            $sql = "SELECT * FROM `users` WHERE user_uname='$uid' ";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if ($resultCheck < 1) {
                http_response_code(400);
            }  elseif($resultCheck > 1) {
                echo "error 500";                
                http_response_code(500);
            } else {
                //take data from db and insert it into an array $row
                //Echo username: echo $row['user_uname'];

                if ($row = mysqli_fetch_assoc($result)) {
                    //De-hashig the password password_verify(user entered password, db password);

                    $hashedPwd = $row['user_pwd'];
                    $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                    if ($hashedPwdCheck == false) {
                        echo "error 401 bad password";                        
                        http_response_code(401);
                        exit();
                    } elseif ($hashedPwdCheck == true) {
                        //check to see if requested sensors to push data is linked to the user doing it
                        $sid = checkSensors($conn, $uid, $sname);
                        if($sid) {
                                if(pushData($conn, $sid[0], $date, $time, $metric)){
                                    echo "success";

                                    //E-MAIL ALERT SYSTEM FOR SMOKE
				    $sql = "SELECT sensor_type FROM sensor WHERE sensor_name='$sname';";
				    $result = mysqli_query($conn, $sql);
 				    $row = mysqli_fetch_row($result);
                                    if($row[0] == "SMOKE" && $metric > 0 ) {
					alertUser($conn, $uid, $sname);   
                                    }
                                    
                                    http_response_code(200);
                                    exit();
                                } else {
                                    http_response_code(400);
                                    exit();
                                }
                        } else {
                            echo "error 401 bad sensor";
                            http_response_code(401);
                        }
                    }
                }
            }
        }

        } else {
        http_response_code(400);
        }
    exit();
         
} else {
    http_response_code(405);
}

?>
