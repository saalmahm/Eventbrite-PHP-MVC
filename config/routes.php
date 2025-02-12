
<?php
use App\Controllers\HomeController;
use App\Controllers\EventController;



// GET routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/events', [EventController::class, 'index']);
$router->get('/events/create', [EventController::class, 'create']);
$router->get('/events/edit/:id', [EventController::class, 'edit']);

// POST routes
$router->post('/events/store', [EventController::class, 'store']);
$router->post('/events/update/:id', [EventController::class, 'update']);
$router->post('/events/delete/:id', [EventController::class, 'delete']);