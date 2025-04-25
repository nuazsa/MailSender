<?php
/**
 * Router class for handling routes and request dispatching.
 */
namespace Nuazsa\MailSender\Services;

class Router
{
    /**
     * Array to store registered routes.
     * @var array
     */
    private static array $routes = [];

    /**
     * Array to store route prefixes.
     * @var array
     */
    private static array $prefixes = [];

    /**
     * Get the full path for a route, including prefixes.
     * @param string $path The path to prefix.
     * @return string The full path.
     */
    private static function getPath(string $path): string
    {
        $prefix = implode('', self::$prefixes);
        return $prefix . $path;
    }

    /**
     * Add a route to the router.
     * @param string $method The HTTP method for the route.
     * @param string $path The route path.
     * @param string $controller The controller class name.
     * @param string $function The controller method name.
     * @param array $middlewares Optional. An array of middleware classes.
     * @return void
     */
    public static function add(string $method, string $path, string $controller, string $function, array $middlewares = []): void
    {
        self::$routes[] = [
            'method' => $method,
            'path' => self::getPath($path),
            'controller' => $controller,
            'function' => $function,
            'middlewares' => $middlewares
        ];
    }

    /**
     * Add a GET route to the router.
     * @param string $path The route path.
     * @param string $controller The controller class name.
     * @param string $function The controller method name.
     * @param array $middlewares Optional. An array of middleware classes.
     * @return void
     */
    public static function get(string $path, string $controller, string $function, array $middlewares = []): void
    {
        self::add('GET', $path, $controller, $function, $middlewares);
    }

    /**
     * Add a POST route to the router.
     * @param string $path The route path.
     * @param string $controller The controller class name.
     * @param string $function The controller method name.
     * @param array $middlewares Optional. An array of middleware classes.
     * @return void
     */
    public static function post(string $path, string $controller, string $function, array $middlewares = []): void
    {
        self::add('POST', $path, $controller, $function, $middlewares);
    }

    /**
     * Add a route prefix to the router.
     * @param string $prefix The prefix to add.
     * @param callable $callback The callback function to execute.
     * @return void
     */
    public static function prefix(string $prefix, callable $callback): void
    {
        self::$prefixes[] = $prefix;
        $callback();
        array_pop(self::$prefixes);
    }

    /**
     * Run the router and dispatch the request.
     * @return void
     */
    public static function run(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route["path"] . "$#";

            if (preg_match($pattern, $path, $matches) && $route['method'] === $method) {
                foreach ($route['middlewares'] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }

                $controller = new $route['controller'];
                $function = $route['function'];

                array_shift($matches); // Remove the full match
                call_user_func_array([$controller, $function], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "Controller not found";
    }
}
