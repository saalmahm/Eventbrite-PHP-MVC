<?php
namespace App\Models;
use App\Models\User;

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

    public function reserverTicket($iduser, $idevent, $idticket, $prix_paye, $status) {
        $sql = "INSERT INTO reservation (iduser, idevent, idticket, date, prix_paye, status, qrcode) 
                VALUES (:iduser, :idevent, :idticket, NOW(), :prix_paye, :status, UUID())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
        $stmt->bindParam(':idevent', $idevent, PDO::PARAM_INT);
        $stmt->bindParam(':idticket', $idticket, PDO::PARAM_INT);
        $stmt->bindParam(':prix_paye', $prix_paye, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        return $stmt->execute();
    }

    
}

?>
