<?php

namespace App\Middleware;

class AuthMiddleware {
    public static function checkAuthentication() {
          // Check if session is set properly
        if (!isset($_SESSION['user'])) {
            $_SESSION['showLoginModal'] = true; 
        } else {
            unset($_SESSION['showLoginModal']); 
        }
    }
    
     
        public static function isAuthenticated(): bool {
            return isset($_SESSION['user']) && !empty($_SESSION['user']);
        }
    
        public static function getUser() {
            return isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
        }
    

    public static function checkUserType($className) {
        self::checkAuthentication();  
        $user = unserialize($_SESSION['user']);

        if (!$user instanceof $className) {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: /');
            exit();
        }
    }
}



