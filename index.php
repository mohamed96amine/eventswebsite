<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
    <script src="script/index.js" ></script>
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <title>Events</title>
</head>

<body>
<div id="header">
    <h1>Events </h1>
</div>

<?php

require('lib/User.php');
session_start();

// Top Menu

require_once('lib/forms.php');
if(isset($_SESSION['user_connected'])  ) {
    echo "<ul id='topmenu'>
            <li class='nav' > <a class=\"active\" href=\"index.php\">Bienvenue ".strtoupper($_SESSION['user_connected']->prenom)."</a></li>
            <li class='nav' > <a href=\"account.php\">Mon Compte</a> </li>
            <li class='nav' > <a href=\"logout.php\">Se Déconnecter</a> </li></ul>";
}else{
    echo "<ul id='topmenu'>
            <li class='nav'> <a href=\"index.php\"> Accueil </a></li>
            <li class='nav'> 
                <div id='loginform'>
                    <form action=\"lib/authen.php\" method='post'>
                        <input type=\"text\" name=\"login\" placeholder='Username*'  style='display:inline'/>
                        <input type=\"password\" name=\"password\" placeholder='Password*' style='display: inline'/>
                        <input type=\"submit\" value=\"Connexion\"  style='display: inline'/>
                    </form>
                </div>
            </li></ul>";
}

?>


<div id ='wrapper'>
    <!--La carte -->


    <div id="map" style="height: 500px" ></div>


    <!--Filtre De Recherche -->


    <div id="formFilter">
     <form action="search.php" method="get">
         <div style="color: #1ab188;margin: 60px;font-family: 'Arial Black'; font-size: large;">Filtrer par : </div><br />
         <div style="color: #1ab188;font-size: large;display: inline-block;">De:</div> <input type="date" name="date1" id="date1" style="width: 42%;">
         <div style="color: #1ab188;font-size: large;display: inline-block;">A :</div> <input type="date" name="date2" id="date2" style="width: 42.5%;"><br />
         <input type="text" name="author" id="author" placeholder="Auteur.." ><br/>
         <input type="text" name="title" id="title" placeholder="Titre.." ><br/>
         <div id="numberpages" style="color: #1ab188;font-size: large;display: inline-block;">  Nombre Evenements Par Page</div>
         <input type="range" min="0" max="20" value="10" id="limit" name="limit" style="margin:20px;width:60%;"/> <br/>
         <img src="icons/loader.gif" alt="loading" width="300" height="30" id="loader" style="display: none;">
     </form>
    </div>
    <?php

        require_once('lib/connection.php');

//        // formulaire de connexion ou d'inscription

      if(!isset($_SESSION['user_connected'])){
        echo "<div id='notconnected'>";
            echo "<div id='signinform'><h2 style='left:160px;top:15px;position: relative;color:#1ab188;'>S'inscrire : </h2><br/>";
            register();
            echo "</div><br/></div>";
       }else{// Bouton de création d'evenements
            echo "<div id='notconnected'>";
            echo "<input type='submit' value='Post An Event!' id='postevent' onclick='post();' style='position:relative;top:200px;'>";
            echo "</div>";
        }

    ?>
</div>
<!--Affichage des boutons suivant et précedant  -->


<div id="pages" style="width: 100%;clear: left;position: relative;top:50px;">
    <input type='image' value='0' id='back' src='icons/backbtn.png' style="top:50px;left:200px;position: relative">
    <div id="page"></div>
    <input type='image' value='0' id='next' src='icons/nextbtn.png' style="left:600px;position: relative">
</div>

<!--Element qui contient les resultats-->



<div id="results"></div>
</body>

</html>