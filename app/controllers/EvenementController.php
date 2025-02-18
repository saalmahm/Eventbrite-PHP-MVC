<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\Evenement;
use App\Middleware\AuthMiddleware;


class EvenementController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates'); 
        $this->twig = new Environment($loader);
    }

public function showEvenement(): void {
    session_start(); 

    $evenements = Evenement::getAllEvenement(); 
    $countEvents = count($evenements);
    $showLoginModal = !isset($_SESSION['user']) || empty($_SESSION['user']);
    
    echo $this->twig->render('evenement.html.twig', [
        'base_url' => '/YouEvent/public/',
        'evenements' => $evenements,
        'showLoginModal' => $showLoginModal,  
        'current_page' => 'evenement',
        'countEvents' => $countEvents,
        'user' => $_SESSION['user'] ?? null
    ]);
}


public function showDetails($id) {
    session_start(); 
    $evenements = Evenement::getEventById($id);
    $types = Evenement::getTypeTicket($id); 

    $payantTicket = $types[0] ;
    $vipTicket = $types[1];

    $showLoginModal = !isset($_SESSION['user']) || empty($_SESSION['user']);

    echo $this->twig->render('details.html.twig', [
        'base_url' => '/YouEvent/public/',
        'evenements' => $evenements,
        'vipTicket' => $vipTicket,
        'showLoginModal' => $showLoginModal,  
        'payantTicket' => $payantTicket,
        'current_page' => 'evenement',
        'eventId' => $id
    ]);
}






    
    
    
    
    

 
}
