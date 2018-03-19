<?php

function authentifier($login, $password){

    try { $connexion = new PDO(

       "mysql:host=localhost;dbname=dbevents","root","");echo "test";

    }catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();
    }
    $stmt = $connexion -> prepare("select login, nom, prenom, password, email, location from users");
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    while ($line = $stmt ->fetch()){
        if(correctPassword($password, $line['password']) && $line['login'] == $login ){
            return new User($login, $line['nom'], $line['prenom'], $line['location'], $line['email']);
        }
    }
    return null;
}
function correctPassword($input, $password){
    //$salt = substr($password, 0, 29);
    //$pass = crypt($input, $salt);

    return $input == $password;
}



function controleAuthentification() {
    print_r($_POST);
    print_r($_REQUEST);
    print_r($_SESSION);
    if(isset($_SESSION['ident']) && is_a($_SESSION['ident'], 'Identite')) {
        echo "authentiifer ";
        return;
    } else if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){

            //$user = authentifier($_REQUEST['login'], $_REQUEST['password']);
            $user = authentifier("test", "test");
            if ($user != null){
                $_SESSION['user_connected'] = $user;
                return ;
            }
        }
    throw new Exception("Vous n'êtes pas connecté!");
}



?>

