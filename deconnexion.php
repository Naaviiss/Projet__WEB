<?php
    session_start();
    if(isset($_SESSION["id"])){
        unset($_SESSION["id"]);
        session_destroy();
    }
    if(isset($_SESSION["nom"])){
        unset($_SESSION["nom"]);
        session_destroy();
    }
    if(isset($_SESSION["status"])){
        unset($_SESSION["status"]);
        session_destroy();
    }
    header('location: index.html');
?>