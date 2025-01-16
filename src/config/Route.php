<?php

namespace config;

class Route
{
    private static array $routes = [];
    private static string $url = '';
    private static array $matches = [];

    public static function init(string $url): void
    {
        self::$url = trim($url, '/');
    }

    public static function get(string $path, callable $callable, ?string $name = null): void
    {
        self::add($path, $callable, $name, 'GET');
    }

    public static function post(string $path, callable $callable, ?string $name = null): void
    {
        self::add($path, $callable, $name, 'POST');
    }

    private static function add(string $path, callable $callable, ?string $name, string $method): void
    {
        self::$routes[$method][] = [
            'path' => $path,
            'callable' => $callable,
            'name' => $name,
        ];
    }

    public static function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        if (!isset(self::$routes[$method])) {
            throw new RouterException("No routes defined for method: $method");
        }

        foreach (self::$routes[$method] as $route) {
            if (self::match($route['path'])) {
                call_user_func_array($route['callable'], self::$matches);
                return;
            }
        }

        // Si aucune route ne correspond, afficher une vue 404
        try {
            View::render('404');
        } catch (\Exception $e) {
            throw new RouterException('No matching route and no 404 view found');
        }
    }

    private static function match(string $path): bool
    {
        $path = trim($path, '/');
        $path = preg_replace_callback('#:([\w]+)#', [self::class, 'paramMatch'], $path);
        $regex = "#^$path$#i";

        if (!preg_match($regex, self::$url, $matches)) {
            return false;
        }
        array_shift($matches);
        self::$matches = $matches;
        return true;
    }

    private static function paramMatch(array $match): string
    {
        return '([^/]+)';
    }
}

class RouterException extends \Exception {}
