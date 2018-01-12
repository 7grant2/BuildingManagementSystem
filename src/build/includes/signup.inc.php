<?php

//Check if user has clicked submit button
if (isset($_POST['submit'])) {
     
  include_once 'dbh.inc.php';

  $fname = mysqli_real_escape_string($conn, $_POST['fname']);
  $lname = mysqli_real_escape_string($conn, $_POST['lname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $uname = mysqli_real_escape_string($conn, $_POST['uname']);
  $pwd1 = mysqli_real_escape_string($conn, $_POST['pwd1']);
  $pwd2 = mysqli_real_escape_string($conn, $_POST['pwd2']);

  //Error handlers
  //Check for empty fields
  
  if (empty($fname) || empty($uname) || empty($lname) || empty($email) || empty($pwd1)  || empty($pwd2)) {
     header("Location: ../signup.php?signup=empty");
      exit();
  } else {
      //Check if input characters are valid
      if (!preg_match("/^[a-zA-Z]*$/", $fname) || !preg_match("/^[a-zA-Z]*$/", $lname) ) {
          header("Location: ../signup.php?signup=invalid");
          exit();
      } else {
          //Check if email is valid          
          if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              header("Location: ../signup.php?signup=email");
              exit();
          } else {
              //Check if users have same username
              $sql = "SELECT * FROM users WHERE uname='uname' ";
              $result = mysqli_query($conn, $sql);
              $resultCheck = mysqli_num_rows($result);
              if($resultCheck > 0) {
                  header("Location: ../signup.php?signup=usertaken");
                  exit();
              }  else {
                  //check if password match
                  if ($pwd1 != $pwd2) {    
                      header("Location: ../signup.php?signup=password");
                      exit();
                  } else {
                      //Hashing the password
                      $hashedPwd = password_hash($pwd1, PASSWORD_BCRYPT, array('cost' => 12));                      
                      //Insert the user into the database
                      $sql = "INSERT INTO `users`(`user_fname`, `user_lname`, `user_email`, `user_uname`, `user_pwd`) VALUES ('$fname', '$lname', '$email', '$uname', '$hashedPwd'); ";
                      
                      $result = mysqli_query($conn, $sql);
                      // header("Location: ../login.php");
                      //exit();                        
                    }
                }
            }
        }
  }
} else {
  header("Location: ../signup.php");
  exit();
}

?>
