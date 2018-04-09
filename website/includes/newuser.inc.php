
<?php
session_start();
//returns true if rows > 0
//Check if user has clicked submit button
if (isset($_POST['submit']) && isset($_SESSION['u_id'])) {
     
  include_once 'dbh.inc.php';
  
  function sqlCheck($sql, $conn) {
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
      if($resultCheck > 0) {
          return true;
      } else {
          return false;
      }
  }
      
  $building =  $_POST['bname'];
  $perm = $_POST['perm'];      
  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pwd1 = mysqli_real_escape_string($conn, $_POST['pwd1']);
  $pwd2 = mysqli_real_escape_string($conn, $_POST['pwd2']);
  $pwd3 = mysqli_real_escape_string($conn, $_POST['pwd3']);  
  $zip = mysqli_real_escape_string($conn, $_POST['zipcode']);
  $newuname = mysqli_real_escape_string($conn, $_POST['uname']);
  $uname =  $_SESSION['u_uname'];
  $uid = $_SESSION['u_id'];
  $bname = array();
  foreach($building as $bid => $bn){
      $sql="SELECT building_id FROM building WHERE building_name ='$bn';";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_row($result);
      array_push($bname, $row[0]);
  }
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
          header("Location: ../newuser.php?user=empty");
          exit();
      } else {
          //Check if input characters are valid
          if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname) || preg_match("/^[a-zA-Z]*$/", $zip)) {
              header("Location: ../newuser.php?user=invalid");
              exit();
          } else {
              //Check if email is valid
              if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  header("Location: ../newuser.php?user=email");
                  exit();
              } else {
                  //check if password match
                  if ($pwd1 != $pwd2) {    
                      header("Location: ../newuser.php?user=password");
                      exit();
                  } else {
                      $sql = "SELECT * FROM users WHERE user_email='$email'; ";
                      if(sqlCheck($sql, $conn)) {
                          header("Location: ../newuser.php?user=emailtaken");
                          exit();
                      }  else {
                          //Hashing the password
                          $hashedPwd = password_hash($pwd2, PASSWORD_BCRYPT, array('cost' => 12)); 
                          //Insert the user into the database AND set permission
                          $sql = "INSERT INTO `users`(`user_fname`, `user_lname`, `user_email`, `user_uname`, `user_pwd`, `user_zip`) VALUES ('$fname', '$lname', '$email', '$newuname', '$hashedPwd', '$zip'); ";
                          $result = mysqli_query($conn, $sql);
                          $sql ="SELECT user_id FROM users WHERE user_uname='$newuname'; ";
                          $result = mysqli_query($conn, $sql);
                          $row = mysqli_fetch_row($result);
                          if($perm == 0) $sql ="INSERT INTO `permission` (`user_id`, `permission_ems`) VALUES ('$row[0]', 1);";
                          else if ($perm == 1) $sql ="INSERT INTO `permission` (`user_id`, `permission_admin`)  VALUES ('$row[0]', 1);";
                          else $sql ="INSERT INTO `permission` (`user_id`) VALUES ('$row[0]');";
                          echo "test";
                          $result = mysqli_query($conn, $sql);
                          foreach($bname as $bid => $bn){
                              $sql = "INSERT INTO users_building (user_id, building_id) VALUES ('$row[0]', $bn);";
                              $result = mysqli_query($conn, $sql);
                          }
                          header("Location: ../index.php");
                          exit();
                      }
                  }
              }
          }
      }
  }
} else {
  header("Location: login.php");
  exit();
}


?>
                    