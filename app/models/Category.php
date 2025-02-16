<?php
namespace App\Models;

use Config\Database;
use PDO;
use PDOException;

class Category {
    private $idCategory;
    private $name;
    private $associatedMusic = [];
    private $conn;

    public function __construct($idCategory = null, $name = null) {
        $this->conn = Database::getConnection();
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

    // Create (Insert) Method
    public function create() {
        try {
            $query = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            
            if ($stmt->execute()) {
                $this->idCategory = $this->conn->lastInsertId();
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Create Category Error: " . $e->getMessage());
            return false;
        }
    }

    // Read (Get) Method - Single Category
    public function read() {
        try {
            $query = "SELECT * FROM categories WHERE id_category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->idCategory);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $this->name = $row['name'];
                return $row;
            }
            return null;
        } catch (PDOException $e) {
            error_log("Read Category Error: " . $e->getMessage());
            return null;
        }
    }

    // Read (Get) Method - All Categories
    public static function readAll() {
        try {
            $conn = Database::getConnection();
            $query = "SELECT * FROM categories";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Read All Categories Error: " . $e->getMessage());
            return [];
        }
    }

    // Update Method
    public function update() {
        try {
            $query = "UPDATE categories SET name = :name WHERE id_category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':id', $this->idCategory);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update Category Error: " . $e->getMessage());
            return false;
        }
    }

    // Delete Method
    public function delete() {
        try {
            $query = "DELETE FROM categories WHERE id_category = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->idCategory);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete Category Error: " . $e->getMessage());
            return false;
        }
    }
    public static function findIdByName($name) {
        try {
            $conn = Database::getConnection();
            $query = "SELECT idcategory FROM category WHERE name = :name LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['id_category'] : null;
        } catch (PDOException $e) {
            error_log("Find ID by Name Error: " . $e->getMessage());
            return null;
        }
    }
}
