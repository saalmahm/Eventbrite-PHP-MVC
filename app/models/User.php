<?php


abstract class User {
    protected $idUser;
    protected $username;
    protected $email;
    protected $password;
    protected $image;
    protected $phone;

    public function __construct($idUser, $username, $email, $password, $image = null, $phone = null) {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
        $this->phone = $phone;
    }

    // Getters
    public function getIdUser() {
        return $this->idUser;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPhone() {
        return $this->phone;
    }

    // Setters
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

}

?>
