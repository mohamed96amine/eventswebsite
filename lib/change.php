<?php

require_once ('util.php');
require_once ('User.php');
session_start();
refresh();
function refresh(){
    if (isset($_REQUEST['lname'],$_REQUEST['fname'], $_REQUEST['password']) ){
        updateDatabase();
        session_destroy();
        echo "<br /><a href=\"../index.php\">Click here to Sign in</a>";
    }
}

function updateDatabase(){
    $nom = $_REQUEST['lname'];
    $prenom = $_REQUEST['fname'];
    $password = $_REQUEST['password'];
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","");
    }catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();
    }
    $sql = "UPDATE users SET nom='".$nom."', prenom='".$prenom."', password='".crypt($password, randomSalt())."' WHERE users.login='".$_SESSION['user_connected']->login."'";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    echo "Changes Saved!";
}

?>