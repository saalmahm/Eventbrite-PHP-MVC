<?php


class Evenement {
    private $idEvent;
    private $titre;
    private $intro;
    private $description;
    private $date;
    private $status;
    private $lieu;
    private $capacite;
    private $category;
    private $organisateur;

    public function __construct($idEvent, $titre, $intro, $description, $date, $status, $lieu, $capacite, $category, $organisateur) {
        $this->idEvent = $idEvent;
        $this->titre = $titre;
        $this->intro = $intro;
        $this->description = $description;
        $this->date = $date;
        $this->status = $status;
        $this->lieu = $lieu;
        $this->capacite = $capacite;
        $this->category = $category;
        $this->organisateur = $organisateur;
    }

    // Getters
    public function getIdEvent() {
        return $this->idEvent;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDate() {
        return $this->date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getLieu() {
        return $this->lieu;
    }

    public function getCapacite() {
        return $this->capacite;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getOrganisateur() {
        return $this->organisateur;
    }

    // Setters
    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setIntro($intro) {
        $this->intro = $intro;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setLieu($lieu) {
        $this->lieu = $lieu;
    }

    public function setCapacite($capacite) {
        $this->capacite = $capacite;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setOrganisateur($organisateur) {
        $this->organisateur = $organisateur;
    }

    
}

?>
