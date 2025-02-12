<?php


class Ticket {
    private $idTicket;
    private $idEvent;
    private $type;
    private $capacite;
    private $prix;

    public function __construct($idTicket, $idEvent, $type, $capacite, $prix) {
        $this->idTicket = $idTicket;
        $this->idEvent = $idEvent;
        $this->type = $type;
        $this->capacite = $capacite;
        $this->prix = $prix;
    }

    // Getters
    public function getIdTicket() {
        return $this->idTicket;
    }

    public function getIdEvent() {
        return $this->idEvent;
    }

    public function getType() {
        return $this->type;
    }

    public function getCapacite() {
        return $this->capacite;
    }

    public function getPrix() {
        return $this->prix;
    }

    // Setters
    public function setType($type) {
        $this->type = $type;
    }

    public function setCapacite($capacite) {
        $this->capacite = $capacite;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    
}

?>
