<?php

class Reservation {
    private $idUser;
    private $idEvent;
    private $idTicket;
    private $date;
    private $prix_paye;
    private $status;
    private $qrCode;

    public function __construct($idUser, $idEvent, $idTicket, $date, $prix_paye, $status, $qrCode) {
        $this->idUser = $idUser;
        $this->idEvent = $idEvent;
        $this->idTicket = $idTicket;
        $this->date = $date;
        $this->prix_paye = $prix_paye;
        $this->status = $status;
        $this->qrCode = $qrCode;
    }

    // Getters
    public function getIdUser() {
        return $this->idUser;
    }

    public function getIdEvent() {
        return $this->idEvent;
    }

    public function getIdTicket() {
        return $this->idTicket;
    }

    public function getDate() {
        return $this->date;
    }

    public function getPrixPaye() {
        return $this->prix_paye;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getQrCode() {
        return $this->qrCode;
    }

    // Setters
    public function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    public function setIdEvent($idEvent) {
        $this->idEvent = $idEvent;
    }

    public function setIdTicket($idTicket) {
        $this->idTicket = $idTicket;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setPrixPaye($prix_paye) {
        $this->prix_paye = $prix_paye;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setQrCode($qrCode) {
        $this->qrCode = $qrCode;
    }

    
}

?>
