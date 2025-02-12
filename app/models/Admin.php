<?php

require_once "User.php";

class Admin extends User {
    
    public function __construct($idUser, $username, $email, $password, $image = null, $phone = null) {
        parent::__construct($idUser, $username, $email, $password, $image, $phone);
    }

   
}

?>
