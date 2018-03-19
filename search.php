
<?php

require_once('lib/Event.php');
header('Content-Type: text/json; charset=utf-8');

check_entry();


function check_entry(){
    if(isset($_GET['author'], $_GET['title'], $_GET['date1'], $_GET['date2'])){
        handle();
    }else{
        echo "it's not working";
    }
}

function handle(){
    $sql = sql();
    $results = json_encode(connect($sql), JSON_UNESCAPED_UNICODE);
    echo $results;
}

function sql(){
    $author = $_GET['author'];
    $title = $_GET['title'];
    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $latmax = $_GET['latmax'];
    $latmin = $_GET['latmin'];
    $lonmax = $_GET['lonmax'];
    $lonmin = $_GET['lonmin'];
    $from = $_GET['from'];
    $limit = $_GET['limit'];
    $sql = "where  lat between '".$latmin."' AND '".$latmax."' AND lon between '".$lonmin."' AND '".$lonmax."' AND author LIKE '".$author."%' AND title LIKE '".$title."%' ";
    if(!empty($date1) && !empty($date2)){
        $sql .= " and date between '".$date1."' and '".$date2."'";
    }else{
        if(!empty($date1)){
            $sql .= " and date >= '".$date1."'";
        }else if(!empty($date2)){
            $sql .= " and date <= '".$date2."'";
        }
    }
    return ($sql." ORDER BY date LIMIT ".$limit." OFFSET ".$from);
}

function connect($sql){
    try { $connexion = new PDO(
        "pgsql:host=localhost;dbname=dbevents","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );}catch (PDOException $e){
        echo ("Erreur de connexion".$e->getMessage());
        exit();}
    $count = explode(" ORDER", $sql)[0];
    $res = $connexion->query("SELECT count(*) from events ".$count);
    $total = $res->fetchColumn();
    $stmt = $connexion -> prepare("select lat, lon, date, author, title, text, id from events ".$sql);
    $stmt -> execute();
    $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $arr = $result = array();
    while ($line = $stmt ->fetch()){
        array_push($arr,new Event($line['lat'], $line['lon'], $line['date'], $line['author'], ($line['title']), $line['text'], $line['id']));
    }
    $result['total'] = $total;
    $result['events'] = $arr;
    return $result;
}


?>

