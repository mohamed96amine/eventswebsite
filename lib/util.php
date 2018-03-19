<?php

function random64String($n){
    static $charset =  "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789./";
    $res ="";
    for ($i=0; $i<$n; $i++){
        $res .= $charset{rand(0,strlen($charset)-1)};
    }
    return $res;
}

function randomSalt(){
    return '$2a$10$'.random64String(22);
}


function usernameAlreadyExits($username){
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","");
    }catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();
    }
    $sql = "SELECT login FROM users ";
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    while ($line = $stmt ->fetch()){
        if($line['login'] === $username){
            return True;
        }
    }
    return False;

}

?>