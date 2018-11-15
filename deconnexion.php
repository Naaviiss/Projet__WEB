<?php
    session_start();
    if(isset($_SESSION["nom"])){
        unset($_SESSION["nom"]);
        session_destroy();
    }
    else{
        header('location: pageconnexion.php');
    }
?>