<?php


class Participant extends User {
    private $billets_reserves = [];

    public function __construct($idUser, $username, $email, $password, $image, $phone) {
        parent::__construct($idUser, $username, $email, $password, $image, $phone);
    }

    // Getters
    public function getBilletsReserves() {
        return $this->billets_reserves;
    }

    // Setters
    public function setBilletsReserves($billets) {
        $this->billets_reserves = $billets;
    }

    
}

?>
