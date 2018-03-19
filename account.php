
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js"></script>
    <script src="script/account.js" charset="UTF-8"></script>
    <link rel="stylesheet" type="text/css" href="style/account.css">
    <title>My Account</title>
</head>
<body>
<div id="header">
    <h1> My Account</h1>
</div>
<?php
require("lib/User.php");
require_once 'lib/connection.php';
session_start();

change_informations();

function change_informations()
{
    echo "<h2>Change Informations</h2>
    <div id='form'>
    <form action='lib/change.php'>
        <fieldset>
        <label for='name' ></label><input type='text' name='lname' id='lname' placeholder='Nom'/><br/>
        <label for='name' ></label>
        <input type='text' name='fname'  id='fname' placeholder='Prenom' />  <br/>
        <label for='password' ></label>
        <input type='password' name='password' id='password'  placeholder='Mot de Pass'/><br />
        <input type=\"submit\" value=\"Submit\" style=\"cursor:pointer; padding:5px 20px; background - color:lightsteelblue; border:dotted 2px grey; border - radius:5px;\">;
        </fieldset>
    </form>
    </div>";
}

?>






</body>
</html>



