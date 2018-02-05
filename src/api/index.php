
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
INNER JOIN users U ON B.user_id = U.user_id
WHERE U.user_uname = '$user'
AND S.sensor_name = '$sname';";
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