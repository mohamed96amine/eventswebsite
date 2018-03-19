<!DOCTYPE html>
<html lang="fr">

<head>

    <script src="script/oneevent.js" ></script>
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <title>Events</title>
</head>

<body>

<?php
require_once('lib/Event.php');

    if(isset($_GET['id'])){
        handle($_GET['id']);
    }else{
        "Erreur , cet evenement n'existe pas ou a été supprimé.";
    }

    function handle($id){
        $ev = getevent($id);
        echo "<div id=\"header\"><h1>".$ev->title."</h1></div>";
        echo "<div id='event' style='background-color: gray'><h1 style='text-align: center;color=lightgoldenrodyellow;'>".$ev->title."</h1><br /><p>".$ev->text."</p><br /><p>Par : ".$ev->author."</p><p> le ".$ev->date."</p></div> ";
    }

    function getevent($id){
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );}catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();}
    $stmt = $connexion -> prepare("select lat, lon, date, author, title, text, id from events where id='".$id."'");
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    while ($line = $stmt ->fetch()){
        $ev = new Event($line['lat'], $line['lon'], $line['date'], $line['author'], ($line['title']), $line['text'], $line['id']);
    }
    return $ev;
    }

?>



</body>
</html>