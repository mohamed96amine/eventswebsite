<?php

//$arr = array('amine'=>"fsd", 'imane', 'fatima-ezzahra');
//
//echo json_encode($arr);
//echo "\n";
//print_r($arr)
/*
require_once 'lib/Event.php';
*/

//phpinfo();
try { $connexion = new PDO(

    "mysql:host=localhost;dbname=dbevents","root","");

}catch (PDOException $e){
    echo ("Erreur de connexion".$e->getMessage());
    exit();
}
$stmt = $connexion -> prepare("select login, nom, prenom, password, email, location from users");
$stmt -> execute();
$stmt -> setFetchMode(PDO::FETCH_ASSOC);
while ($line = $stmt ->fetch()){
    //if(correctPassword($password, $line['password']) && $line['login'] == $login ){
       // return new User($login, $line['nom'], $line['prenom'], $line['location'], $line['email']);
    echo $line['nom'];
    echo $line['prenom'];
}
?>