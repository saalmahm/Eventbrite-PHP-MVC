<?php
namespace App\Models;
require_once __DIR__ . '/../../config/Database.php';

use Config\Database;
use PDO;

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

    // Méthodes CRUD
    public function creer() {
        try {
            $conn = Database::getConnection();
            $query = "INSERT INTO evenement 
                (titre, intro, description, date, status, lieu, ville, capacite, category, organisateur) 
                VALUES (:titre, :intro, :description, :date, :status, :lieu, :ville, :capacite, :category, :organisateur)";
            
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
                ':organisateur' => $this->organisateur
            ]);
            
            $this->idEvent = $conn->lastInsertId();
            
            return ['success' => true, 'message' => 'Événement créé avec succès', 'idEvent' => $this->idEvent];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Erreur: ' . $e->getMessage()];
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

  


    
}

?>
