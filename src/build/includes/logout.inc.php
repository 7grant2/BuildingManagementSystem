<?php

if (isset($_POST['submit'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php?signout=success");
    exit();
} else {
    echo "unknown error";
}

?>