<?php
    session_start();
    if(isset($_SESSION["nom"])){
        unset($_SESSION["nom"]);
        session_destroy();
    }
    if(isset($_SESSION["role"])){
        unset($_SESSION["role"]);
        session_destroy();
    }
    header('location: index.php');
?>
