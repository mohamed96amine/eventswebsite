
<?php
require('User.php');

session_start();

check_entry();

function check_entry(){
    if(!isset($_SESSION['user_connected'])){
        header("Location: ../index.php");
    }
    if(condition()){
        store();
    }else{
        echo "Wrong Input Retry!";
    }
}

function store(){
    $sql = sql();
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","");
    }catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();
    }
    $stmt = $connexion->prepare($sql);
    $stmt->execute();
    echo " Your Event has been added successfully ";
}

function sql(){

    $author = $_SESSION['user_connected']->login;
    $title = $_GET['title'];
    $text = $_GET['text'];
    $date = $_GET['date'];
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];
    $sql = "INSERT INTO events(title, text, date, lat, lon, author) VALUES('".$title."','".$text."','".$date."','".$lat."','".$lon."','".$author."')";
    return $sql;
}


function condition(){
    if(isset($_GET['title'], $_GET['text'], $_GET['date'], $_GET['lat'], $_GET['lon']) &&
        (!empty($_GET['title']) && !empty($_GET['text']) && !empty($_GET['date'])&& !empty($_GET['lat'])&& !empty($_GET['lon']) )) {
        return true;
    }else{
        return false;
    }
}

?>

