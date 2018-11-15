<?php
    session_start();
    if(isset($_SESSION["nom"])){
        unset($_SESSION["nom"]);
        session_destroy();
    }
    header('location: pageconnexion.php');
?>