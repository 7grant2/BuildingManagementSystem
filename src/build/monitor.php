<?php
include_once 'header.php';
if (!isset($_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
} else {
    echo "
    <div class='jumbotron'>
    <div class='row text-center'>
    <h1>Monitor</h1>
    </div>
    </div>

    <div class='jumbotron col-sm-10 col-sm-offset-1'>
    
";
    include_once 'includes/monitor.inc.php';
    echo "
    </div>

";
}


include_once 'footer.php';
?>




