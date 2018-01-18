
<?php
session_start();
echo "test";
if(isset($_SESSION['u_id'])) {

    
}
//Check if user is logged in
/*
echo isset($_SESSION['u_id'));

if(isset($_SESSION['u_id'])) {
    
    include_once 'dbh.inc.php';
    
    function sqlCheck($sql, $conn) {
        $result = mysqli_query($conn, $sql);


        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            return $result;
        } else {
            return false;
        }
    } 
      
       
        //Displays data relating to building id
        function displayData($b_id) {
            echo $b_id;
            // string floor[];

            
            $sql = "SELECT * FROM floor WHERE building_id='$b_id'; ";
            $result = sqlCheck($sql, $conn);
            while($row = mysqli_fetch_array($result)) {
                echo "<h2>", $row[floor_id],"</h2>";
                $b_id = $row[building_id];
            } 
            
           
            //loop through each floor in rooms
            $sql = "SELECT room_id FROM room WHERE floor_id='$f_id[$x]'";
            $result = sqlCheck($sql, $conn);


            //loop through each room in sensor
            $sql = "SELECT sensor_id FROM sensor WHERE room_id='$r_id[$x]'";
            $result = sqlCheck($sql, $conn);

            //loop through each sensor in room to get sensor type
            $sql = "SELECT sensor_type FROM sensor WHERE sensor_id='$s_id[$x]'";
            $result = sqlCheck($sql, $conn);
      
            //loop through each reading per sensor to get reading values
            $sql = "SELECT reading_date, reading_time, reading_value FROM reading WHERE sensor_id='$s_id[$x]'";
            $result = sqlCheck($sql, $conn);

        }

        

      
      echo "<div class='center-text col-sm-10 col-sm-offset-1'>";
      $uid = $_SESSION['u_id'];
      $sql = "SELECT * FROM building WHERE user_id='$uid'; ";
      $result = sqlCheck($sql, $conn);
      if($result == false) {
          echo "0 rows <br>";
      } else {
          echo "test";
          //if buildings > 1, do dropdown
          //if buildings = 1, display as header
          if(mysqli_num_rows($result) > 1) {

              
              echo "
  <div class='btn-group'>
    <p>SELECT BUILDING: </p>
    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      select <span class='caret'></span>
    </button>
    <ul class='dropdown-menu'> ";
              
                  while($row = mysqli_fetch_array($result)) {
                      echo "<li><a href='#'>", $row[building_name],"</a></li>";
                  } 
                  echo "
    </ul>
  </div>";
                  //$b_id should reflect currently selected building

                  // $displayData($b_id);
              
          } else {
              echo "test";
              
              $b_id;
              while($row = mysqli_fetch_array($result)) {
                  echo "<h2>", $row[building_name],"</h2>";
                  $b_id = $row[building_id];
              }
              //  $displayData($b_id);

          }
             

              
//Else, just display the building not in a dropdown with according info
          
          
      


      echo "</div>";
   
    

}


 else {
  header("Location: ../index.php")
  exit();
  }
*/
?>
