<?php
session_start();
if(!isset($_SESSION['u_id'])){
    header("Location ../index.php");
} else {
    if ($_SESSION['sa'] !=1 && $_SESSION['admin'] != 1) {
        header("Location: ../index.php");
    } 
    include '../includes/dbh.inc.php';
    $u_uname = $_SESSION['u_uname'];

    //BUILDING
    if(isset($_POST['b_pwd'])){
        //VERIFY PASSWORD BEFORE CONTINUING
        $pwd = mysqli_real_escape_string($conn, $_POST['b_pwd']);
        $sql = "SELECT user_pwd FROM users WHERE user_uname='$u_uname' ;";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pwd, $row['user_pwd'])){
            if(isset($_POST['add-bname'])){
                $n = mysqli_real_escape_string($conn, $_POST['add-bname']);    
                $sql="INSERT INTO building (building_name) VALUES ('$n');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../building.php?ret=success");
                } else {
                    header("Location: ../building.php?ret=failure");
                }
            } 
            else if (isset($_POST['mod-bname'])){
                $n = mysqli_real_escape_string($conn, $_POST['mod-bname']);    
                $s = mysqli_real_escape_string($conn, $_POST['mod-bname-s']);    
                $sql="UPDATE building SET building_name='$n' WHERE building_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../building.php?ret=success");
                } else {
                    header("Location: ../building.php?ret=failure");
                }

            }
            else if (isset($_POST['del-bname-s'])){
                $s = mysqli_real_escape_string($conn, $_POST['del-bname-s']);    
                $sql="DELETE FROM building WHERE building_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../building.php?ret=success");
                } else {
                    header("Location: ../building.php?ret=failure");
                }

            }
        } else {
            header("Location: ../building.php?ret=failure");
        }
    }
    //IF FLOORS
    elseif(isset($_POST['f_pwd'])) {
        //VERIFY PASSWORD BEFORE CONTINUING
        $pwd = mysqli_real_escape_string($conn, $_POST['f_pwd']);
        $sql = "SELECT user_pwd FROM users WHERE user_uname='$u_uname';";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pwd, $row['user_pwd'])){
            if(isset($_POST['add-fname-s']) && isset($_POST['add-fnum-n']) && isset($_POST['add-fname-n'])){
                $n = mysqli_real_escape_string($conn, $_POST['add-fname-n']);
                $s = mysqli_real_escape_string($conn, $_POST['add-fname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['add-fnum-n']);
                $sql="INSERT INTO floor (building_id, floor_name, floor_num) VALUES ('$s', '$n', '$q');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../floor.php?ret=success");
                } else {
                    header("Location: ../floor.php?ret=failure");
                }


            } 
            if(isset($_POST['mod-fname-s']) && isset($_POST['mod-fnum-n']) && isset($_POST['mod-fname-n'])){
                $n = mysqli_real_escape_string($conn, $_POST['mod-fname-n']);
                $s = mysqli_real_escape_string($conn, $_POST['mod-fname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['mod-fnum-n']);
                $sql="UPDATE floor SET floor_name='$n', floor_num='$q' WHERE floor_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../floor.php?ret=success");
                } else {
                    header("Location: ../floor.php?ret=failure");
                }

            }
            if(isset($_POST['del-fname-s'])){
                $n = mysqli_real_escape_string($conn, $_POST['del-fname-s']);
                $sql="DELETE FROM floor WHERE floor_id='$n';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../floor.php?ret=success");
                } else {
                    header("Location: ../floor.php?ret=failure");
                }
            }



        } else {
            header("Location: ../floor.php?ret=failure");
        }
    }
    //IF ROOMS
    else if(isset($_POST['r_pwd'])) {
        //VERIFY PASSWORD BEFORE CONTINUING
        $pwd = mysqli_real_escape_string($conn, $_POST['r_pwd']);
        $sql = "SELECT user_pwd FROM users WHERE user_uname='$u_uname' ;";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pwd, $row['user_pwd'])){
            if(isset($_POST['add-rname-s']) && isset($_POST['add-rnum-n']) && isset($_POST['add-rname-n'])){
                $n = mysqli_real_escape_string($conn, $_POST['add-rname-n']);
                $s = mysqli_real_escape_string($conn, $_POST['add-rname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['add-rnum-n']);                
                $sql="INSERT INTO room (floor_id, room_name, room_num) VALUES ('$s', '$n', '$q');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../room.php?ret=success");
                } else {
                    header("Location: ../room.php?ret=failure");
                }
            }
            else if(isset($_POST['mod-rname-s']) && isset($_POST['mod-rnum-n']) && isset($_POST['mod-rname-n'])){
                $n = mysqli_real_escape_string($conn, $_POST['mod-rname-n']);
                $s = mysqli_real_escape_string($conn, $_POST['mod-rname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['mod-rnum-n']); 
                $sql="UPDATE room SET room_name='$n', room_num='$q' WHERE room_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../room.php?ret=success");
                } else {
                    header("Location: ../room.php?ret=failure");
                }

            }
            else if (isset($_POST['del-rname-n'])){
                echo $_POST['del-rname-n'];
                $n = mysqli_real_escape_string($conn, $_POST['del-rname-n']);
                $sql="DELETE FROM room WHERE room_id='$n';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../room.php?ret=success");
                } else {
                    header("Location: ../room.php?ret=failure");
                }
            }
        } else {
            header("Location: ../room.php?ret=failure");
        }
    }
    //IF SENSORS
    else if(isset($_POST['s_pwd'])) {
        //VERIFY PASSWORD BEFORE CONTINUING
        $pwd = mysqli_real_escape_string($conn, $_POST['s_pwd']);
        $sql = "SELECT user_pwd FROM users WHERE user_uname='$u_uname' ;";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pwd, $row['user_pwd'])){
            if(isset($_POST['add-sname-s']) && isset($_POST['add-sname-n']) && isset($_POST['add-stype'])){
                $s = mysqli_real_escape_string($conn, $_POST['add-sname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['add-snum-n']);                
                $t = mysqli_real_escape_string($conn, $_POST['add-stype']);
                $sql="INSERT INTO sensor (room_id, sensor_name, sensor_type) VALUES ('$s', '$q', '$t');";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../sensor.php?ret=success");
                } else {
                    header("Location: ../sensor.php?ret=failure");
                }
            } 
            elseif(isset($_POST['mod-sname-s']) && isset($_POST['mod-snum-n']) && isset($_POST['mod-stype'])){
                $s = mysqli_real_escape_string($conn, $_POST['mod-sname-s']);
                $q = mysqli_real_escape_string($conn, $_POST['mod-snum-n']);                
                $t = mysqli_real_escape_string($conn, $_POST['mod-stype']);
                $sql="UPDATE sensor SET sensor_type='$t', sensor_name='$q' WHERE sensor_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../sensor.php?ret=success");
                } else {
                    header("Location: ../sensor.php?ret=failure");
                }

            }
            else if (isset($_POST['del-sname-s'])){
                $s = mysqli_real_escape_string($conn, $_POST['del-sname-s']);                
                $sql="DELETE FROM sensor WHERE sensor_id='$s';";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../sensor.php?ret=success");
                } else {
                    header("Location: ../sensor.php?ret=failure");
                }




                $result = mysqli_query($conn, $sql);
                if ($result) {
                    header("Location: ../sensor.php?ret=success");
                } else {
                    header("Location: ../sensor.php?ret=failure");
                }
            }

        } else {
            header("Location: ../sensor.php?ret=failure");
        }
    }
    //USER
        else if(isset($_POST['u_pwd'])) {
        //VERIFY PASSWORD BEFORE CONTINUING
            $pwd = mysqli_real_escape_string($conn, $_POST['u_pwd']);
            $sql = "SELECT user_pwd FROM users WHERE user_uname='$u_uname' ;";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pwd, $row['user_pwd'])){
                if(isset($_POST['del-uname-s'])){
                    $s = mysqli_real_escape_string($conn, $_POST['del-uname-s']);
                    $sql="DELETE FROM users WHERE user_id='$s'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        header("Location: ../deluser.php?ret=success");
                    } else {
                        header("Location: ../deluser.php?ret=failure");
                    }
                } 
            } else {
                header("Location: ../deluser.php?ret=failure");
            }
        }
    //done
}
?>