<?php
namespace App\Models;

require_once __DIR__ . '/../../config/Database.php';

use Config\Database;
use PDO;
use PDOException;

class Ticket {
    private $idTicket;
    private $idEvent;
    private $type;
    private $capacite;
    private $prix;

    public function __construct($idTicket = null, $idEvent = null, $type = null, $capacite = null, $prix = null) {
        $this->idTicket = $idTicket;
        $this->idEvent = $idEvent;
        $this->type = $type;
        $this->capacite = $capacite;
        $this->prix = $prix;
    }

    // Getters
    public function getIdTicket() { return $this->idTicket; }
    public function getIdEvent() { return $this->idEvent; }
    public function getType() { return $this->type; }
    public function getCapacite() { return $this->capacite; }
    public function getPrix() { return $this->prix; }

    // Setters
    public function setType($type) { $this->type = $type; }
    public function setCapacite($capacite) { $this->capacite = $capacite; }
    public function setPrix($prix) { $this->prix = $prix; }

    // Méthodes CRUD
    public function creer() {
        try {
            $conn = Database::getConnection();
            $query = "INSERT INTO ticket 
                (type, capacite, prix) 
                VALUES (:type, :capacite, :prix)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':capacite', $this->capacite);
            $stmt->bindParam(':prix', $this->prix);
            
            $stmt->execute();
            $this->idTicket = $conn->lastInsertId();
            
            return [
                'success' => true,
                'message' => 'Ticket créé avec succès',
                'idTicket' => $this->idTicket
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la création du ticket: ' . $e->getMessage()
            ];
        }
    }

    public function modifier() {
        try {
            $conn = Database::getConnection();
            $query = "UPDATE ticket SET 
                idEvent = :idEvent, 
                type = :type, 
                capacite = :capacite, 
                prix = :prix 
                WHERE idTicket = :idTicket";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idEvent', $this->idEvent);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':capacite', $this->capacite);
            $stmt->bindParam(':prix', $this->prix);
            $stmt->bindParam(':idTicket', $this->idTicket);
            
            $stmt->execute();
            
            return [
                'success' => true,
                'message' => 'Ticket modifié avec succès'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la modification du ticket: ' . $e->getMessage()
            ];
        }
    }

    public function supprimer() {
        try {
            $conn = Database::getConnection();
            $query = "DELETE FROM ticket WHERE idTicket = :idTicket";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idTicket', $this->idTicket);
            
            $stmt->execute();
            
            return [
                'success' => true,
                'message' => 'Ticket supprimé avec succès'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression du ticket: ' . $e->getMessage()
            ];
        }
    }

    public function rechercher() {
        try {
            $conn = Database::getConnection();
            $query = "SELECT * FROM ticket WHERE idTicket = :idTicket";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idTicket', $this->idTicket);
            $stmt->execute();
            
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultat) {
                return [
                    'success' => true,
                    'message' => 'Ticket trouvé',
                    'resultat' => $resultat
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Aucun ticket trouvé'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la recherche du ticket: ' . $e->getMessage()
            ];
        }
    }
}
?>
