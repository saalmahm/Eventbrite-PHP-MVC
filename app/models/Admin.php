<?php

namespace App\Models;
use App\Models\User;

class Admin extends User {
    

    public function __construct($idUser, $username, $email, $password, $image, $phone) {
        parent::__construct($idUser, $username, $email, $password, $image, $phone);
    }

    
}

?>
