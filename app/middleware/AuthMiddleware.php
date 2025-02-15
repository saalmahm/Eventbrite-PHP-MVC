<?php
class AuthMiddleware {
    
    public static function checkAuthentication() {
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vous devez vous connecter pour accéder à cette page.";
            header('Location: /login');
            exit();
        }
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
    public static function checkUser($username) {
        self::checkAuthentication();  

        $user = unserialize($_SESSION['user']);

        if ($user->getUsername() != $username) {
            $_SESSION['error'] = "Accès non autorisé.";
            header('Location: /');
            exit();
        }
    }
    
}
