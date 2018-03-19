<?php


class User
{
    public $login;
    public $nom;
    public $prenom;
    public $location;
    public $email;

    function __construct($login, $nom, $prenom, $location, $email){
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->location =$location;
        $this-> email = $email;
    }
        
}

?>