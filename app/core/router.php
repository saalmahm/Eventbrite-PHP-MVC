<?php

namespace App\Core;

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

        throw new \Exception('Route not found', 404);
    }

    private function matchRoute(string $routePath, string $requestPath): bool {
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');

        if ($routePath === '' && $requestPath === '') {
            return true;
        }

        $routeSegments = $routePath ? explode('/', $routePath) : [];
        $requestSegments = $requestPath ? explode('/', $requestPath) : [];

        if (count($routeSegments) !== count($requestSegments)) {
            return false;
        }

        foreach ($routeSegments as $key => $segment) {
            if (strpos($segment, ':') === 0) {
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
            if (strpos($segment, ':') === 0) {
                $paramName = substr($segment, 1);
                $params[$paramName] = $requestSegments[$key];
            }
        }

        return $params;
    }
}
