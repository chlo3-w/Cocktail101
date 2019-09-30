<?php
    session_start();
    if (isset($_SESSION['logged'])){
    $s_username = $_SESSION['username'];
    $message = "You are already logged in as $s_username.";
    header("Location: http://me15cw.leedsnewmedia.net/COMM2735/WebApp/home.php");
    die();
    }
?>
