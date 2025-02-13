
<?php

use App\Controllers\UserController;


// // GET routes
$router->get('/', [UserController::class, 'showHome']);
$router->get('/login', [UserController::class, 'showLogin']);
$router->get('/register', [UserController::class, 'showRegistre']);

// POST routes
$router->post('/register', [UserController::class, 'registerUser']);
$router->post('/login', [UserController::class, 'loginUser']);




// // GET routes
// $router->get('/', [HomeController::class, 'index']);
// $router->get('/events', [EventController::class, 'index']);
// $router->get('/events/create', [EventController::class, 'create']);
// $router->get('/events/edit/:id', [EventController::class, 'edit']);

// $router->post('/events/store', [EventController::class, 'store']);
// $router->post('/events/update/:id', [EventController::class, 'update']);
// $router->post('/events/delete/:id', [EventController::class, 'delete']);