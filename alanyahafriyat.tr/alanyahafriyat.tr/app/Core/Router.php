<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    protected array $routes = ['GET' => [], 'POST' => []];
    protected $notFound;

    public function get(string $path, array|callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    protected function add(string $method, string $path, array|callable $handler): void
    {
        $path = '/' . trim($path, '/');
        if ($path === '/') {
            $pattern = '#^/?$#';
        } else {
            $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $path);
            $pattern = '#^' . $regex . '/?$#';
        }
        $this->routes[$method][] = ['pattern' => $pattern, 'handler' => $handler];
    }

    public function setNotFound(callable $handler): void
    {
        $this->notFound = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = urldecode($path);
        // public/ alt dizininde çalışırken base path'i temizle
        $path = '/' . trim($path, '/');

        if ($method === 'POST' && isset($_POST['_method'])) {
            $override = strtoupper($_POST['_method']);
            if (in_array($override, ['PUT', 'PATCH', 'DELETE'], true)) {
                // form tabanlı override'lar POST rotalarına eşlenir
            }
        }

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->invoke($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        if ($this->notFound) {
            ($this->notFound)();
        } else {
            echo '404 Not Found';
        }
    }

    protected function invoke(array|callable $handler, array $params): void
    {
        if (is_callable($handler)) {
            $handler($params);
            return;
        }
        [$class, $action] = $handler;
        $controller = new $class();
        $controller->$action($params);
    }
}
