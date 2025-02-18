<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\User;
use App\Models\Evenement;
use App\Models\Category;
use App\Middleware\AuthMiddleware;




class UserController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates'); 
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
        session_start();
        if (isset($_POST['login_button'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = User::login($email, $password);
    
            if ($user) {
                $_SESSION['user'] = serialize($user); 
                $_SESSION['showLoginModal'] = false;
                
                $userClass = get_class($user);
    
                if ($userClass === 'App\Models\Admin') {
                    header('Location: dashboard');
                    exit(); 
                } elseif ($userClass === 'App\Models\Participant') {
                    header('Location: evenement');
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
        echo $this->twig->render('login.html.twig', ['base_url' => '/YouEvent/public/',
    ]);
    }

    public function showHome() {
        session_start(); 

        $evenements = Evenement::getAllEvenement(); 
        $showLoginModal = !isset($_SESSION['user']) || empty($_SESSION['user']);
        
        echo $this->twig->render('home.html.twig', [
            'base_url' => '/YouEvent/public/',
            'evenements' => $evenements,
            'showLoginModal' => $showLoginModal,  
            'current_page' => 'home',
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    public function showAbout() {
        echo $this->twig->render('a-propos.html.twig', [
            'base_url' => '/YouEvent/public/', 
            'current_page' => 'a-propos'
        ]);
    }
    
    public function showContact() {
        echo $this->twig->render('contact.html.twig', [
            'base_url' => '/YouEvent/public/', 
            'current_page' => 'contact'
        ]);
    }

    public function showDashboard() {
        echo $this->twig->render('dashbord.html.twig', [
            'base_url' => '/YouEvent/public/', 
        ]);
    }
    

    public function reserveTicket() {
        session_start();
        if (!isset($_SESSION['user'])) {
            echo json_encode(['error' => 'Utilisateur non connecté.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $iduser = $_POST['iduser'] ?? null;
            $idevent = $_POST['idevent'] ?? null;
            $idticket = $_POST['idticket'] ?? null;
            $prix_paye = $_POST['prix_paye'] ?? 0;
            $status = $_POST['status'] ?? 'en attente';

            if (!$iduser || !$idevent || !$idticket) {
                echo json_encode(['error' => 'Données incomplètes.']);
                return;
            }

            $reservation = new Reservation();
            $reservation->iduser = $iduser;
            $reservation->idevent = $idevent;
            $reservation->idticket = $idticket;
            $reservation->date = date('Y-m-d H:i:s');
            $reservation->prix_paye = $prix_paye;
            $reservation->status = $status;
            $reservation->qrcode = Str::uuid();

            if ($reservation->save()) {
                echo json_encode(['success' => 'Réservation effectuée avec succès.', 'reservation' => $reservation]);
            } else {
                echo json_encode(['error' => 'Erreur lors de la réservation.']);
            }
        }
    }

    public function showAddEvent() {
        echo $this->twig->render('addEvent.html.twig', ['base_url' => '/YouEvent/public/']);
    }

    public function addEvent() {
        if (isset($_POST['addEvent'])) {
            $title = trim($_POST['title'] ?? '');
            $category = 1;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
                $uploadDir = 'assets/images/uploads/covers/';
                $uploadFile = $uploadDir . basename($image['name']);
    
                if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
                    $imagePath = basename($image['name']);
                } else {
                    echo "<script>alert('Failed to upload image.');</script>";
                    return;
                }
            } else {
                $imagePath = null;
            }
    
            $location = trim($_POST['location'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $date = $_POST['date'] ?? '';
            $ville = $_POST['ville'] ?? '';
            $status = 'en attente';
    
            $gratuit_capacity = intval($_POST['gratuit_capacity'] ?? 0);
            $earlybird_capacity = intval($_POST['earlybird_capacity'] ?? 0);
            $earlybird_price = intval($_POST['earlybird_price'] ?? 0);
            $payant_capacity = intval($_POST['payant_capacity'] ?? 0);
            $payant_price = intval($_POST['payant_price'] ?? 0);
            $vip_capacity = intval($_POST['vip_capacity'] ?? 0);
            $vip_price = intval($_POST['vip_price'] ?? 0);
    
            $organisateur = 9;
            $capacite = $gratuit_capacity + $earlybird_capacity + $payant_capacity + $vip_capacity;
    
            $ticketgratuit = ['type' => 'gratuit', 'capacity' =>  $gratuit_capacity, 'price' => 0  ];
            $ticketearlybird = ['type' => 'early bird', 'capacity' => $earlybird_capacity, 'price' => $earlybird_price  ];
            $ticketpayant = ['type' => 'payant', 'capacity' => $payant_capacity, 'price' => $payant_price ];
            $ticketvip = ['type' => 'VIP', 'capacity' =>  $vip_capacity, 'price' =>$vip_price  ];

            $tickets = [$ticketgratuit, $ticketearlybird, $ticketpayant, $ticketvip];
    
            // if (empty($title) || empty($category) || empty($location) || empty($description) || empty($date) || empty($ville)) {
            //     echo $this->twig->render('login.html.twig', [
            //         'base_url' => '/YouEvent/public/',
            //         'error_message' => 'Tous les champs sont obligatoires.'
            //     ]);
            //     return;
            // } else {
                $event = new Evenement(null, $title, $imagePath, $description, $date, $status, $location, $ville, $capacite, $category, $organisateur);
                $result = $event->creer($tickets);
    
                if ($result['success']) {
                    header('Location: /YouEvent/');
                    exit;
                } else {
                    echo "hhhhh";
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
               
                echo $this->twig->render('editEvent.html.twig', [
                    'base_url' => '/YouEvent/public/',
                    'error_message' => 'Tous les champs sont obligatoires.'
                ]);
                return;
            } else {
                $event = new Evenement($eventId, $titre, $intro, $description, $date, $status, $lieu, $capacite, $category, $organisateur);
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
                $event = new Evenement($eventId);
                $result = $event->supprimer($eventId);
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
