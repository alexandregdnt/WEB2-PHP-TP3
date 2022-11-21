<?php
// Display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../vendor/autoload.php';

use App\Routes\Route;

$controllersDir = dirname(__FILE__) . '/../src/Controllers/';
$dirs = scandir($controllersDir);
$url = "/" . trim(explode("?", $_SERVER['REQUEST_URI'])[0], "/");
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
$routesObj = [];
$controllers = [];

foreach ($dirs as $dir) {
    if ($dir === '.' || $dir === '..') {
        continue;
    }

    $controllers[] = "App\\Controllers\\" . pathinfo($controllersDir . DIRECTORY_SEPARATOR . $dir, PATHINFO_FILENAME);
}

foreach ($controllers as $controller) {
    try {
        $reflexion = new ReflectionClass($controller);

        foreach ($reflexion->getMethods() as $method) {
            foreach ($method->getAttributes() as $attribute) {
                /** @var Route $route */
                $route = $attribute->newInstance();
                $route->setController($controller)
                    ->setAction($method->getName());

                $routesObj[] = $route;
            }
        }
    } catch (ReflectionException $e) {
        continue;
    }
}

foreach ($routesObj as $route) {
    if (!$route->macth($url) || !in_array($_SERVER["REQUEST_METHOD"], $route->getMethods())) {
        continue;
    }

    $controllerClassName = $route->getController();
    $action = $route->getAction();
    $params = $route->mergeParams($url);

//    new $controllerClassName($action, $params, $user);
    echo [new $controllerClassName(), $action](...$params);
    exit;
}

http_response_code(404);
echo '404 Not Found ;-(';
