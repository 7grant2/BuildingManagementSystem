<?php
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_POST['submit'])) {
    include 'dbh.inc.php';
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    //Error handlers
    //Check if inputs are empty
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
    } else {
        //Does user exist in DB
        $sql = "SELECT * FROM `users` WHERE user_uname='$uid' ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?login=error");
        } else {
            //take data from db and insert it into an array $row
            if ($row = mysqli_fetch_assoc($result)) {
                //De-hashig the password password_verify(user entered password, db password);

                $hashedPwd = $row['user_pwd'];
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } else {
                    //Log in the user here
                    //Use Session variable - global php variable
                    //store permission as well
                    $user_id = $row['user_id'];
                    $sql = "SELECT permission_sa, permission_ems, permission_admin FROM permission WHERE user_id =$user_id;";
                    $result = mysqli_query($conn, $sql);
                    if ($resultCheck != 1) {
                        header("Location: ../index.php?login=error");
                    } else {
                        $perm =  mysqli_fetch_assoc($result);
                        //Get all building ID's associated to the user and set them to session var.
                        $uzip =  $row['user_zip'];
                        
                        if ($perm['permission_ems'] == true) {
                            $sql = "SELECT building_id FROM address WHERE address_zip = $uzip";
                        } else if ($perm['permission_sa'] == true) {
                            $sql = "SELECT building_id FROM building;";
                        } else {
                            $sql = "SELECT building_id FROM users_building WHERE user_id = $user_id";
                        }
                        
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) == 1) {
                            $bid =  mysqli_fetch_assoc($result);
                        } else {
                            $bid = array();
                            while($b = mysqli_fetch_assoc($result)) {
                                array_push($bid, $b['building_id']);
                            }
                        }
                        $_SESSION['buildings'] = $bid;
                        $_SESSION['u_id'] = $row['user_id'];
                        $_SESSION['u_first'] = $row['user_fname'];
                        $_SESSION['u_last'] = $row['user_lname'];
                        $_SESSION['u_email'] = $row['user_email'];
                        $_SESSION['u_uname'] = $row['user_uname'];
                        $_SESSION['u_zip'] = $row['user_zip'];
                        $_SESSION['sa'] = $perm['permission_sa'];;
                        $_SESSION['ems'] = $perm['permission_ems'];
                        $_SESSION['admin'] = $perm['permission_admin'];
                        header("Location: ../index.php?login=success");
                        exit();
                    }
                }
            }
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}

?>