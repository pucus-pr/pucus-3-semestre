<?php
session_start();

function myAutoloader($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('myAutoloader');

$routes = [];
require_once __DIR__ . '/../routes/web.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} else {
    $user = null;
}

foreach ($routes[$method] as $routeUri => $controllerMethod) {
    $pattern = preg_replace('/\{(\w+)\}/', '(\d+)', $routeUri);
    $pattern = str_replace('/', '\/', $pattern); // Escapa barras para a regex
    $pattern = '/^' . $pattern . '$/';

    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);

        list($controller, $method) = $controllerMethod;
        $controllerInstance = new $controller();
        $response = $controllerInstance->$method(...$matches);
        if(isset($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        exit;
    }
}