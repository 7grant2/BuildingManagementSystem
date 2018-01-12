<?php
include_once 'header.php';

?>

<?php
    if (!isset($_SESSION['u_id'])) {
   echo "<div class='container text-center'>
  <div class='col-xs-12 col-sm-12'>
    <h1 >Building Management System</h1>
  </div>
  
  <div class='col-xs-12 col-sm-4'>
    <h3 class='fancy-h'>Real Time Monitoring</h3>
    <img class='center-block img-responsive' src='img/img1.jpg'/>
    <p class='fancy-p'>Never worry about keeping tabs on loved ones at assisted living facility or nursing. The BMS gathers necessary information that is concerned with safety with minimum privacy invasion.</p>
  </div>

  <div class='col-xs-12 col-sm-4'>
    <h3 class='fancy-h'>Further Security Protection Availble</h3>
    <img class='center-block img-responsive' src='img/img2.jpg'/>
    <p class='fancy-p'>With additional modules available, RFID technology can be used to keep track of individiual locations that is encrypted and stored. Skipping school becomes a thing of the past. </p>
  </div>

  <div class='col-xs-12 col-sm-4'>
    <h3 class='fancy-h'>Emergency Services On Standby</h3>
    <img class='center-block img-responsive' src='img/img3.jpg'/>
    <p class='fancy-p'>Our website makes it easy to monitor your loved ones room at senior living facilities to aid firefighters to determine occupancy when necessary.</p>
  </div>


      
</div>";
  } else {
   echo "
    <div class='jumbotron'>
      <div class='row text-center'>
	  <h1>Dashboard</h1>
	  </div>
    </div>
";

  }


?>








<?php
include_once 'footer.php';

?>
