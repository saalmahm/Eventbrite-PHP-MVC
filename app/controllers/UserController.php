<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\User;
use App\Models\Event;


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
    
    public function showRegister() {
        echo $this->twig->render('register.html.twig', ['base_url' => '/YouEvent/public/']);
    }

    public function showAddEvent() {
        echo $this->twig->render('add_event.html.twig', ['base_url' => '/YouEvent/public/']);
    }

    public function addEvent() {
        if (isset($_POST['add_event_button'])) {
            $titre = trim($_POST['title'] ?? '');
            $intro = trim($_POST['intro'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $date = $_POST['date'] ?? '';
            $status = 'en attente';
            $lieu = trim($_POST['location'] ?? '');
            $capacite = trim($_POST['capacity'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $organisateur = trim($_POST['organizer'] ?? '');

            if (empty($titre) || empty($intro) || empty($description) || empty($date) || empty($status) || empty($lieu) || empty($capacite) || empty($category) || empty($organisateur)) {
                echo $this->twig->render('add_event.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Tous les champs sont obligatoires.'
                ]);
                return;
            } else {
                $event = new Event(null, $titre, $intro, $description, $date, $status, $lieu, $capacite, $category, $organisateur);
                $result = $event->creer();
                if ($result['success']) {
                    header('Location: events');
                    exit;
                } else {
                    echo $this->twig->render('add_event.html.twig', [
                        'base_url' => '/YouEvent/public/',
                        'error_message' => $result['message']
                    ]);
                }
            }
        }
    }

    public function editEvent() {
        if (isset($_POST['edit_event_button'])) {
            $eventId = $_POST['event_id'] ?? null;
            $titre = trim($_POST['title'] ?? '');
            $intro = trim($_POST['intro'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $date = $_POST['date'] ?? '';
            $status = trim($_POST['status'] ?? '');
            $lieu = trim($_POST['location'] ?? '');
            $capacite = trim($_POST['capacity'] ?? '');
            $category = trim($_POST['category'] ?? '');
            $organisateur = trim($_POST['organizer'] ?? '');

            if (empty($eventId) || empty($titre) || empty($intro) || empty($description) || empty($date) || empty($status) || empty($lieu) || empty($capacite) || empty($category) || empty($organisateur)) {
                echo $this->twig->render('edit_event.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Tous les champs sont obligatoires.'
                ]);
                return;
            } else {
                $event = new Event($eventId, $titre, $intro, $description, $date, $status, $lieu, $capacite, $category, $organisateur);
                $result = $event->modifier();
                if ($result['success']) {
                    header('Location: events');
                    exit;
                } else {
                    echo $this->twig->render('edit_event.html.twig', [
                        'base_url' => '/YouEvent/public/',
                        'error_message' => $result['message']
                    ]);
                }
            }
        }
    }
    public function deleteEvent() {
        if (isset($_POST['delete_event_button'])) {
            $eventId = $_POST['event_id'] ?? null;
            if ($eventId) {
                $event = new Event($eventId);
                $result = $event->supprimer();
                if ($result['success']) {
                    header('Location: events');
                    exit;
                } else {
                    echo $this->twig->render('events.html.twig', [
                        'base_url' => '/YouEvent/public/',
                        'error_message' => $result['message']
                    ]);
                }
            } else {
                echo $this->twig->render('events.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Event ID is missing.'
                ]);
            }
        }
    }



}
