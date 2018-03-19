<?php


session_start();
session_destroy();
//echo "<br /><a href=\"index.php\">Click here to Sign in</a>";
header("Location: index.php");
?>