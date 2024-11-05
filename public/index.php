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

// foreach ($routes[$method] as $routeUri => $controllerMethod) {
//     $pattern = preg_replace('/\{(\w+)\}/', '(\d+)', $routeUri);
//     $pattern = str_replace('/', '\/', $pattern); // Escapa barras para a regex
//     $pattern = '/^' . $pattern . '$/';

//     if (preg_match($pattern, $uri, $matches)) {
//         // Remove o primeiro elemento, que é a correspondência completa da regex
//         array_shift($matches);

//         // Extrai o controlador e o método
//         list($controller, $method) = $controllerMethod;

//         // Instancia o controlador e chama o método, passando os parâmetros capturados
//         print_r((new $controller())->$method(...$matches));
//         exit;
//     }
// }

$controller = $routes[$method][$uri][0];
$method = $routes[$method][$uri][1];

$controllerInstance = new $controller();

$response = $controllerInstance->$method();

if(isset($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
}