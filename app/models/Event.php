<?php
namespace App\Models;

require_once __DIR__ . '/../../config/Database.php';

use Config\Database;
use PDO;
use PDOException;
use App\Models\Ticket;

class Event {
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

    public function __construct($idEvent = null, $titre = null, $intro = null, $description = null, 
                                $date = null, $status = null, $lieu = null, $capacite = null, 
                                $category = null, $organisateur = null) {
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

    // Getters et Setters (précédents)
    public function getIdEvent() { return $this->idEvent; }
    public function getTitre() { return $this->titre; }
    public function getIntro() { return $this->intro; }
    public function getDescription() { return $this->description; }
    public function getDate() { return $this->date; }
    public function getStatus() { return $this->status; }
    public function getLieu() { return $this->lieu; }
    public function getCapacite() { return $this->capacite; }
    public function getCategory() { return $this->category; }
    public function getOrganisateur() { return $this->organisateur; }

    // Setters
    public function setTitre($titre) { $this->titre = $titre; }
    public function setIntro($intro) { $this->intro = $intro; }
    public function setDescription($description) { $this->description = $description; }
    public function setDate($date) { $this->date = $date; }
    public function setStatus($status) { $this->status = $status; }
    public function setLieu($lieu) { $this->lieu = $lieu; }
    public function setCapacite($capacite) { $this->capacite = $capacite; }
    public function setCategory($category) { $this->category = $category; }
    public function setOrganisateur($organisateur) { $this->organisateur = $organisateur; }

    // Méthodes CRUD
    public function creer($tickets = []) {
        try {
            $conn = Database::getConnection();
            $conn->beginTransaction();

            $categoryValue = is_array($this->category) ? implode(',', $this->category) : $this->category;
            $organisateurValue = '1';

            $query = "INSERT INTO evenement 
            (titre, intro, description, date, status, lieu, capacite, idcategory, idorganisateur) 
            VALUES (:titre, :intro, :description, :date, :status, :lieu, :capacite ,:category, :organisateur)";

            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':titre' => $this->titre,
                ':intro' => $this->intro,
                ':description' => $this->description,
                ':date' => $this->date,
                ':status' => $this->status,
                ':lieu' => $this->lieu,
                ':capacite' => $this->capacite,
                ':category' => $this->category,
                ':organisateur' => $this-> $organisateurValue
            ]);
            
            // $this->idEvent = $conn->lastInsertId();
            // // Création des tickets
            // foreach ($tickets as $ticketData) {
            //     $quantity = $ticketData['capacity'] ;
            //     for ($i = 1; $i <= $quantity; $i++) {
            //         $ticket = new Ticket(null, $this->idEvent, $ticketData['type'], 'Disponible', $ticketData['prix']);
            //         $result = $ticket->creer();
            //         if (!$result['success']) {
            //             throw new PDOException($result['message']);
            //         }
            //     }
            // }

            // $conn->commit();

            // return [
            //     'success' => true,
            //     'message' => 'Événement créé avec succès',
            //     'idEvent' => $this->idEvent
            // ];
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
                titre = :titre, 
                intro = :intro, 
                description = :description, 
                date = :date, 
                status = :status, 
                lieu = :lieu, 
                capacite = :capacite, 
                category = :category, 
                organisateur = :organisateur 
                WHERE idEvent = :idEvent";
            
            $stmt = $conn->prepare($query);
            $stmt->execute([
                ':titre' => $this->titre,
                ':intro' => $this->intro,
                ':description' => $this->description,
                ':date' => $this->date,
                ':status' => $this->status,
                ':lieu' => $this->lieu,
                ':capacite' => $this->capacite,
                ':category' => $this->category,
                ':organisateur' => $this->organisateur,
                ':idEvent' => $this->idEvent
            ]);
            
            return [
                'success' => true,
                'message' => 'Événement modifié avec succès'
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la modification de l\'événement: ' . $e->getMessage()
            ];
        }
    }

    public function supprimer() {
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
            $stmt->bindParam(':idEvent', $this->idEvent);
            
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

    public function rechercher() {
        try {
            $conn = Database::getConnection();
            $query = "SELECT * FROM evenement WHERE idEvent = :idEvent";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idEvent', $this->idEvent);
            $stmt->execute();
            
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($resultat) {
                return [
                    'success' => true,
                    'message' => 'Événement trouvé',
                    'resultat' => $resultat
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Aucun événement trouvé'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la recherche de l\'événement: ' . $e->getMessage()
            ];
        }
    }
}
?>
