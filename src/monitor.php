<?php
include_once 'header.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
} else {
    echo "
    <div class='jumbotron'>
      <div class='row text-center fancy-h'>
        <h1>Monitor</h1>
        <p class='fancy-p'>Pulls latest date and time information for each building</p>
      </div>
    </div>";
    include_once 'includes/monitor.inc.php';
}

include_once 'footer.php';
?>




