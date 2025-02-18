<?php
namespace App\Models;
require_once __DIR__ . '/../../config/Database.php';

use Config\Database;
use PDO;
use PDOException;
use App\Models\Ticket;

class Evenement {
    private $idEvent;
    private $titre;
    private $intro;
    private $description;
    private $date;
    private $status;
    private $lieu;
    private $ville;
    private $capacite;
    private $category;
    private $organisateur;

    public function __construct($idEvent = null, $titre = null, $intro = null, $description = null, 
                                $date = null, $status = null, $lieu = null, $ville = null, $capacite = null, 
                                $category = null, $organisateur = null) {
        $this->idEvent = $idEvent;
        $this->titre = $titre;
        $this->intro = $intro;
        $this->description = $description;
        $this->date = $date;
        $this->status = $status;
        $this->lieu = $lieu;
        $this->ville = $ville;
        $this->capacite = $capacite;
        $this->category = $category;
        $this->organisateur = $organisateur;
    }

    // Getters et Setters
    public function getIdEvent() { return $this->idEvent; }
    public function getTitre() { return $this->titre; }
    public function getIntro() { return $this->intro; }
    public function getDescription() { return $this->description; }
    public function getDate() { return $this->date; }
    public function getStatus() { return $this->status; }
    public function getLieu() { return $this->lieu; }
    public function getVille() { return $this->ville; }
    public function getCapacite() { return $this->capacite; }
    public function getCategory() { return $this->category; }
    public function getOrganisateur() { return $this->organisateur; }

    public function setTitre($titre) { $this->titre = $titre; }
    public function setIntro($intro) { $this->intro = $intro; }
    public function setDescription($description) { $this->description = $description; }
    public function setDate($date) { $this->date = $date; }
    public function setStatus($status) { $this->status = $status; }
    public function setLieu($lieu) { $this->lieu = $lieu; }
    public function setVille($ville) { $this->ville = $ville; }
    public function setCapacite($capacite) { $this->capacite = $capacite; }
    public function setCategory($category) { $this->category = $category; }
    public function setOrganisateur($organisateur) { $this->organisateur = $organisateur; }

    public function creer($tickets = []) {
        try {
            $conn = Database::getConnection();
            $conn->beginTransaction(); // ✅ Start transaction
        
            // Insert event
            $query = "INSERT INTO evenement (titre, ville, lieu, date, capacite, idcategory, idorganisateur, status, intro, description)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            $stmt->bindParam(1, $this->titre, PDO::PARAM_STR);
            $stmt->bindParam(2, $this->ville, PDO::PARAM_STR);
            $stmt->bindParam(3, $this->lieu, PDO::PARAM_STR);
            $stmt->bindParam(4, $this->date, PDO::PARAM_STR);
            $stmt->bindParam(5, $this->capacite, PDO::PARAM_INT);
            $stmt->bindParam(6, $this->category, PDO::PARAM_INT);
            $stmt->bindParam(7, $this->organisateur, PDO::PARAM_INT);
            $stmt->bindParam(8, $this->status, PDO::PARAM_STR);
            $stmt->bindParam(9, $this->intro, PDO::PARAM_STR);
            $stmt->bindParam(10, $this->description, PDO::PARAM_STR);
        
            $stmt->execute();
            $eventId = $conn->lastInsertId(); // ✅ Get the inserted event ID
        
            // Insert tickets
            $ticketQuery = "INSERT INTO ticket (idevent, type, capacite, prix) VALUES (?, ?, 'Disponible', ?)";
            $ticketStmt = $conn->prepare($ticketQuery);
        
            foreach ($tickets as $ticketData) {
                $quantity = intval($ticketData['capacity']);
                for ($i = 0; $i < $quantity; $i++) {
                    $ticketStmt->bindParam(1, $eventId, PDO::PARAM_INT);
                    $ticketStmt->bindParam(2, $ticketData['type'], PDO::PARAM_STR);
                    $ticketStmt->bindParam(3, $ticketData['price'], PDO::PARAM_STR);
                    $ticketStmt->execute();
                }
            }
        
            $conn->commit(); // ✅ Commit everything if successful
            return [
                'success' => true,
                'message' => 'Événement créé avec succès',
                'idEvent' => $this->idEvent
            ];
        } catch (PDOException $e) {
            $conn->rollBack();
            return [
                'success' => false,
                'message' => 'Erreur lors de la création de l\'événement: ' . $e->getMessage()
            ];
        }
        
    }
    

    public function modifier() {
        try {
            $conn = Database::getConnection();
            $query = "UPDATE evenement SET 
                titre = :titre, intro = :intro, description = :description, date = :date, 
                status = :status, lieu = :lieu, ville = :ville, capacite = :capacite, 
                category = :category, organisateur = :organisateur 
                WHERE idEvent = :idEvent";
            
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':titre' => $this->titre,
                ':intro' => $this->intro,
                ':description' => $this->description,
                ':date' => $this->date,
                ':status' => $this->status,
                ':lieu' => $this->lieu,
                ':ville' => $this->ville,
                ':capacite' => $this->capacite,
                ':category' => $this->category,
                ':organisateur' => $this->organisateur,
                ':idEvent' => $this->idEvent
            ]);
            
            return ['success' => true, 'message' => 'Événement modifié avec succès'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
        }
    }

        public static function getAllEvenement(): array
        {
            $conn = Database::getConnection();  
            $sql = "SELECT DISTINCT ON (e.idevent) e.*,  t.* FROM evenement e JOIN ticket t ON e.idevent = t.idevent WHERE t.type = 'payant' and t.capacite = 'Disponible' ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $evenement = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $evenement;
        }

        public static function getEventById(int $id): array
        {
            $conn = Database::getConnection();  
            $sql = "SELECT * FROM evenement e JOIN ticket t ON e.idevent = t.idevent WHERE e.idevent = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $evenement = $stmt->fetch(PDO::FETCH_ASSOC);
            return $evenement;
        }

        public static function getTypeTicket(int $id): array
        {
            $conn = Database::getConnection();  
            $sql = "SELECT DISTINCT ON (t.type) t.type, e.*, t.* FROM evenement e JOIN ticket t ON e.idevent = t.idevent WHERE e.idevent = ?  AND t.type IN ('VIP', 'payant') ORDER BY t.type, t.idticket ASC;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $type = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $type;
        }
        public function supprimer($idEvent) {
            if ($this->idEvent === null) {
                return [
                    'success' => false,
                    'message' => 'ID de l\'événement non spécifié'
                ];
            }
    
            try {
                $conn = Database::getConnection();
                $query = "DELETE FROM evenement WHERE idEvent = :idEvent";
                
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':idEvent', $idEvent);
                
                $stmt->execute();
                
                return [
                    'success' => true,
                    'message' => 'Événement supprimé avec succès'
                ];
            } catch (PDOException $e) {
                return [
                    'success' => false,
                    'message' => 'Erreur lors de la suppression de l\'événement: ' . $e->getMessage()
                ];
            }
        }

  


    
}

?>