<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class OrganisateurController {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates'); // Assurez-vous que le dossier existe
        $this->twig = new Environment($loader);
    }

    // public function showEvenement() {
    //     $evenements = Evenement::getAllEvenement();
    //     // var_dump($evenements);
    //     echo $this->twig->render('home.html.twig', [
    //         'base_url' => '/YouEvent/public/',
    //         'evenements' => $evenements
    //     ]);
    // }
    



}
