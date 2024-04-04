<?php
    session_start();
    include ("utility.php");
    if (isset($_SESSION['user'])) {
        session_destroy();
        redirect("../index.php");
    }
    redirect("../index.php");
?>