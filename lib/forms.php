<?php


function register(){
    echo "<form action='lib/successfulRegistration.php' method='post'>
        <label for='name'> </label><input type='text' name='lname' id='lname' placeholder='Nom*'/> <br/>
        <label for='name'> </label><input type='text' name='fname' id='fname' placeholder='Prenom*'/>  <br/>
        <label for='username'> </label><input type='text' name='username' id='username' placeholder='Username*'/> <br/>
        <label for='password'> </label><input type='password' name='password' id='password' placeholder='Password*'/> <br />
        <label for='email'> </label><input type='text' name='email' placeholder='E-mail'> <br />
        <label for='location'> </label><input type='text' name='location' placeholder='Location'> <br/>
        <input type=\"submit\" value=\"S'inscrire\" >
    </form>";
}

function form(){
    echo "<form action=\"lib/authen.php/\" method='post'>";
    echo "<input type=\"text\" name=\"login\" placeholder='Username*' />";
    echo "<input type=\"password\" name=\"password\" placeholder='Password*' style=\"border:solid 1px black; border-radius:5px; text-align:center; box-shadow:0 0 6px;\"/>
    <input type=\"submit\" value=\"Connexion\" >
    </form>";
}


?>