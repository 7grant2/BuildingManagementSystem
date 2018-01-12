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
            //Echo username: echo $row['user_uname'];

            if ($row = mysqli_fetch_assoc($result)) {
                //De-hashig the password password_verify(user entered password, db password);

                $hashedPwd = $row['user_pwd'];
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true) {
                    //Log in the user here
                    //Use Session variable - global php variable
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_fname'];
                    $_SESSION['u_last'] = $row['user_lname'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uname'] = $row['user_uname'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
            }
        }
    }
} else {
        echo "error <br>";
        // header("Location: ../index.php?login=error");
    exit();
}

?>