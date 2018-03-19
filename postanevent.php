<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
    <script src="script/postanevent.js" charset="UTF-8"></script>
    <link rel="stylesheet" type="text/css" href="style/postanevent.css">
    <title>Post An Event</title>
</head>
<body>
<div id="header">
    <h1> Post An Event </h1>
</div>
<?php


session_start();

if(!isset($_SESSION['user_connected'])) {
    header("Location: index.php");
}

?>

<ul id='topmenu'>
    <li id='nav'><a class="active" href="index.php">Home </a></li>
    <li id='nav'><a href="account.php">My Account</a></li>
    <li id='nav'><a href="logout.php">Log Out</a></li>
</ul>
<div id="notification">
    <p>
        Message
    </p>
</div>

<div id="postevent">
    <!--    La carte -->


    <div id="map"></div>


    <!--    Formulaire -->


    <div id="form">
        <input id='title' name="title" type="text" placeholder="Titre..">
        <textarea id="text" name="text"  placeholder="Description.."></textarea>
        <input id='date' name="date" type="date">
        <input id="send" name="submit" type="submit" value="Envoyer"  >
        <img src="/icons/loader.gif" alt="loading" width="300" height="30" id="loader" style="display: none;">
    </div>
</div>



