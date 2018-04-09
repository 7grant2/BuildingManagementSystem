
<?php
session_start();
//returns true if rows > 0
//Check if user has clicked submit button
if (isset($_POST['submit'])) {
     
  include_once 'dbh.inc.php';

  function sqlCheck($sql, $conn) {
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
      if($resultCheck > 0) {
          //          echo ">0 rows <br>";
          return true;
      } else {
          //          echo "=0 rows <br>";
          return false;
      }
  }
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pwd1 = mysqli_real_escape_string($conn, $_POST['pwd1']);
  $pwd2 = mysqli_real_escape_string($conn, $_POST['pwd2']);
  $pwd3 = mysqli_real_escape_string($conn, $_POST['pwd3']);  
  $zip = mysqli_real_escape_string($conn, $_POST['zipcode']);
  $uname =  $_SESSION['u_uname'];
  $uid = $_SESSION['u_id'];

  //verify password before continuing
  $sql = "SELECT * FROM `users` WHERE user_id='$uid' ";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $hashedPwd = $row['user_id'];
  $hashedPwdCheck = password_verify($pwd3, $row['user_pwd']);
  if ($hashedPwdCheck == false) {
      header("Location: ../index.php?login=error");
      exit();
  } else {
      //Error handlers
      //Check for empty fields 
      if (empty($fname) || empty($lname) || empty($email) || empty($pwd1)  || empty($pwd2) || empty($zip) || empty($pwd3)) {
          header("Location: ../settings.php?settings=empty");
          exit();
      } else {
          //Check if input characters are valid
          if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname) || preg_match("/^[a-zA-Z]*$/", $zip)) {
              header("Location: ../settings.php?settings=invalid");
              exit();
          } else {
              //Check if email is valid          
              if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  header("Location: ../settings.php?settings=email");
                  exit();
              } else {
                  //check if password match
                  if ($pwd1 != $pwd2) {    
                      header("Location: ../settings.php?settings=password");
                      exit();
                  } else {
                      $sql = "SELECT * FROM users WHERE user_email='$email'; ";
                      if(sqlCheck($sql, $conn)) {
                          header("Location: ../settings.php?settings=emailtaken");
                          exit();
                      }  else {
                          //Hashing the password
                          $hashedPwd = password_hash($pwd3, PASSWORD_BCRYPT, array('cost' => 12)); 
                          //Insert the user into the database AND set permission
                          $sql = "UPDATE users SET user_fname='$fname', user_lname='$lname', user_email='$email', user_pwd='$pwd3', user_zip=$zip WHERE user_id=$uid";
                          $result = mysqli_query($conn, $sql);
                          echo "test";
                          header("Location: ../index.php");
                          exit();
                      }
                  }
              }
          }
      }
  }
} else {
  header("Location: ../login.php");
  exit();
}


?>
                    