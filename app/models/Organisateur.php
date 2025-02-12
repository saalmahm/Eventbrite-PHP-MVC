<?php


require_once "User.php";

class Organisateur extends User {
    private $evenements_crees = [];

    public function __construct($idUser, $username, $email, $password, $image = null, $phone = null) {
        parent::__construct($idUser, $username, $email, $password, $image, $phone);
    }

    
}

?>
