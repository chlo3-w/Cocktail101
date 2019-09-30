<?php
    session_start();
        if($_SESSION['logged'] == "logged"){
            include_once("headerlogged.html");
        }else{
            include_once("header.html");
        }
?>