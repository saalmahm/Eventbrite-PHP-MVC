<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;


$route = $_GET['route'] ?? '/';

$router = new Router();
include __DIR__ . '/../config/routes.php';
$router->dispatch($route);
