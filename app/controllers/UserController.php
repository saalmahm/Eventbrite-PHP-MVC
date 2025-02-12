<?php

require_once __DIR__ . '../models/User.php';  




class UserController {

    public function registerUser() {

        if (isset($_POST['register_button'])) {
            $name = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';
        
            // Check if any field is empty
            if (empty($name) || empty($email) || empty($password) || empty($role)) {
                exit();
            }

            if (User::isEmailTaken($email)) {
                echo "<script>alert('Cet email est déjà pris.');</script>";
                return;
            } else {
                User::register($name, $email, $password, $role, "");
                $_SESSION['message'] = 'Inscription réussie!';      
                header('Location: /login');

            }
        }
        
    }

    public function loginUser(): void {
        if (isset($_POST['login_button'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

        $user = User::login($email, $password);
    
        if ($user) {
            $_SESSION['user'] = serialize($user);

            if ($user instanceof Admin) {
                header('Location: /admin/dashboard');
            } elseif ($user instanceof Participant) {
                header('Location: /dashboard');
            } elseif ($user instanceof Organisateur) {
                header('Location: /organisateur/dashboard');
            } else {
                header('Location: /login'); 
            }
            exit();
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header('Location: /login');
            exit();
        }
    }       
    }

    

    public function showLogin() {
        require_once __DIR__ . '/../views/login.php';
    }

    public function showRegistre() {
        require_once __DIR__ . '/../views/registre.php';
    }



   

}
