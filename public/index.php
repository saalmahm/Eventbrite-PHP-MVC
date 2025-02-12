<?php


require_once __DIR__ . '/../vendor/autoload.php'; 

error_reporting(E_ALL & ~E_DEPRECATED);

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates'); 
$twig = new Environment($loader);


$template = 'register.html.twig'; 

// Render template
echo $twig->render('register.html.twig', ['base_url' => './public/']);


// use App\Core\Router;

// $router = new Router();

// // Include routes
// require_once __DIR__ . '/../config/routes.php';

// // Dispatch the router
// $router->dispatch();
