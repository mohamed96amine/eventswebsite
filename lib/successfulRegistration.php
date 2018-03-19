<?php
require "util.php";

init ();
function addToDatabase(){
    $nom = $_REQUEST['lname'];
    $prenom = $_REQUEST['fname'];
    $login = $_REQUEST['username'];
    $password =  $_REQUEST['password'];
    $email =  $_REQUEST['email'];
    $location =  $_REQUEST['location'];
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","");
    }catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();
    }
    $sql = "INSERT INTO users(nom, prenom, login, password, email, location) VALUES ('".$nom."','".$prenom."','".$login."','".crypt($password, randomSalt())."','".$email."','".$location."')";//."')";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
}

function init(){
    if(condition()){
        if(!usernameAlreadyExits($_REQUEST['username'])) {
            addToDatabase();
            echo "Welcome ".$_REQUEST['lname']." ".$_REQUEST['fname']." You've registred successfully!";
            echo "<br /><a href=\"../index.php\">Click here to Sign in</a>";
        }else{
            echo $_REQUEST['username']." is already used , choose another username!";
            echo "<br /><a href=\"../index.php\">Click here to Sign in or retry Log in</a>";
        }
    }else{
        echo "Wrong inputs ! ";
        echo "<br /><a href=\"../index.php\">Click here to retry or Sign up</a>";

    }
}

function condition(){
    return isset($_REQUEST['lname'],$_REQUEST['fname'], $_REQUEST['username'],$_REQUEST['password'], $_REQUEST['email'], $_REQUEST['location']) &&
    !empty($_REQUEST['username']) && !empty($_REQUEST['fname']) && !empty($_REQUEST['password']) && !empty($_REQUEST['lname']);
}



?>