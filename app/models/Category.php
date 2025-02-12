<?php


class Category {
    private $idCategory;
    private $name;
    private $associatedMusic = [];

    public function __construct($idCategory, $name) {
        $this->idCategory = $idCategory;
        $this->name = $name;
    }

    // Getters
    public function getIdCategory() {
        return $this->idCategory;
    }

    public function getName() {
        return $this->name;
    }

    public function getAssociatedMusic() {
        return $this->associatedMusic;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setAssociatedMusic($associatedMusic) {
        $this->associatedMusic = $associatedMusic;
    }

    
}

?>
