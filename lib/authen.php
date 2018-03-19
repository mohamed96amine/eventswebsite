<?php
require("User.php");
require ('connection.php');

session_start();

try{

    controleAuthentification();
    header("Location: ../index.php");
}catch(Exception $e){
    echo "Wrong inputs <br /><a href=\"../index.php\">Home</a>";
    exit();
}

?>