<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\User;


class UserController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates'); // Assurez-vous que le dossier existe
        $this->twig = new Environment($loader);
    }

    public function registerUser() {
        if (isset($_POST['register_button'])) {
            $name = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = strtolower(trim($_POST['role'] ?? ''));

            if (User::isEmailTaken($email)) {
                echo $this->twig->render('register.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Cet email est déjà pris.'
                ]);
                return;
            } else {
                User::register($name, $email, $password, $role);
                header('Location: login');
                exit;
            }
        }
    }

    public function loginUser(): void {
        if (isset($_POST['login_button'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = User::login($email, $password);
    
            if ($user) {
                $_SESSION['user'] = $user;
                
                $userClass = get_class($user);
    
                if ($userClass === 'App\Models\Admin') {
                    header('Location: dashboard');
                    exit(); 
                } elseif ($userClass === 'App\Models\Participant') {
                    header('Location: evenements');
                    exit(); 
                } elseif ($userClass === 'App\Models\Organisateur') {
                    header('Location: dashboard');
                    exit(); 
                }
            } else {
                echo $this->twig->render('login.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Email ou mot de passe incorrect.'
                ]);
                exit();
            }
        }
    }
    
    

    public function showLogin() {
        echo $this->twig->render('login.html.twig', ['base_url' => '/YouEvent/public/']);
    }

    public function showHome() {
        echo $this->twig->render('home.html.twig', ['base_url' => '/YouEvent/public/']);
    }
    public function showRegistre() {
        echo $this->twig->render('register.html.twig', ['base_url' => '/YouEvent/public/']);
    }
}
