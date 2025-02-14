<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO("pgsql:host=localhost;port=5432;dbname=YouEvent", "postgres", "salmahm");
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             
            } catch (PDOException $e) {
                echo "Database connection failed: " . $e->getMessage();  
                self::$conn = null;
            }
        }

        return self::$conn;  
    }
}




