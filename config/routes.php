
<?php

use App\Controllers\UserController;
use App\Controllers\EvenementController;
use App\Middleware\AuthMiddleware;

AuthMiddleware::checkAuthentication();



// // GET routes
$router->get('/', [UserController::class, 'showHome']);
$router->get('/login', [UserController::class, 'showLogin']);
$router->get('/register', [UserController::class, 'showRegistre']);
$router->get('/evenement', [EvenementController::class, 'showEvenement']);
$router->get('/contact', [UserController::class, 'showContact']);
$router->get('/a-propos', [UserController::class, 'showAbout']);
$router->get('/evenement/details/{id}', [EvenementController::class, 'showDetails']);
$router->get('/dashboard/addEvent', [UserController::class,'showAddEvent']);
$router->get('/dashboard', [UserController::class,'showDashboard']);


// POST routes
$router->post('/register', [UserController::class, 'registerUser']);
$router->post('/login', [UserController::class, 'loginUser']);
$router->post('/evenement/details/{id}', [UserController::class, 'loginUser']);
$router->post('/dashboard/addEvent/', [UserController::class,'addEvent'] );




// // GET routes
// $router->get('/', [HomeController::class, 'index']);
// $router->get('/events', [EventController::class, 'index']);
// $router->get('/events/create', [EventController::class, 'create']);
// $router->get('/events/edit/:id', [EventController::class, 'edit']);

// $router->post('/events/store', [EventController::class, 'store']);
// $router->post('/events/update/:id', [EventController::class, 'update']);
// $router->post('/events/delete/:id', [EventController::class, 'delete']);