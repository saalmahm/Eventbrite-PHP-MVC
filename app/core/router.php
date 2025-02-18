<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Router {
    private array $routes = [];
    private array $middlewares = [];

    public function addRoute(string $method, string $path, array $handler, array $middleware = []): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function get(string $path, array $handler, array $middleware = []): void {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function addMiddleware(string $name, callable $middleware): void {
        $this->middlewares[$name] = $middleware;
    }

    public function dispatch(?string $requestUri = null, ?string $requestMethod = null): mixed {
        $requestUri = $requestUri ?? $_SERVER['REQUEST_URI'];
        $requestMethod = $requestMethod ?? $_SERVER['REQUEST_METHOD'];
        $path = parse_url($requestUri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($this->matchRoute($route['path'], $path) && $route['method'] === $requestMethod) {
                // Execute middlewares
                foreach ($route['middleware'] as $middleware) {
                    if (isset($this->middlewares[$middleware])) {
                        $response = ($this->middlewares[$middleware])();
                        if ($response !== true) {
                            return $response;
                        }
                    }
                }

                // Extract parameters from the URL
                $params = $this->extractParams($route['path'], $path);

                // Execute controller action
                $controller = new $route['handler'][0]();
                $action = $route['handler'][1];

                return !empty($params) ? $controller->$action(...array_values($params)) : $controller->$action();
            }
        }

        // If no route matched, render the 404 page
        $this->render404();
    }

    private function render404(): void {
        header("HTTP/1.1 404 Not Found");

        // Initialize Twig inside the render404 method
        $loader = new FilesystemLoader(__DIR__ . '/../../templates'); // Adjust the path as needed
        $twig = new Environment($loader);

        // Render the 404 page
        echo $twig->render('404.html.twig', ['base_url' => '/YouEvent/public/']);

        exit();  // Make sure to stop further execution after showing the 404 page
    }

    private function matchRoute(string $routePath, string $requestPath): bool {
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');

        if ($routePath === '' && $requestPath === '') {
            return true;
        }

        $routeSegments = explode('/', $routePath);
        $requestSegments = explode('/', $requestPath);

        if (count($routeSegments) !== count($requestSegments)) {
            return false;
        }

        foreach ($routeSegments as $key => $segment) {
            // Check for dynamic parameters (e.g. {id})
            if (strpos($segment, '{') === 0 && strpos($segment, '}') !== false) {
                continue;
            }

            if (!isset($requestSegments[$key]) || $segment !== $requestSegments[$key]) {
                return false;
            }
        }

        return true;
    }

    private function extractParams(string $routePath, string $requestPath): array {
        $params = [];
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');
        $routeSegments = explode('/', $routePath);
        $requestSegments = explode('/', $requestPath);

        foreach ($routeSegments as $key => $segment) {
            // If the segment is a dynamic parameter (e.g. {id})
            if (strpos($segment, '{') === 0 && strpos($segment, '}') !== false) {
                $paramName = substr($segment, 1, -1); // Extract the param name without the curly braces
                $params[$paramName] = $requestSegments[$key];
            }
        }

        return $params;
    }
}
