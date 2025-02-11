<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("pgsql:host=localhost;port=5432;dbname=YouEvent", "postgres", "0000");
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "good";
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                echo "An error occurred while connecting to the database. Please try again later.";
                self::$conn = null;  
            }
        }

        return self::$conn;  
    }
}


//  ha kifach t3ayat l database
// $conn = Database::getConnection();  

