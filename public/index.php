<?php
session_start();

function myAutoloader($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
spl_autoload_register('myAutoloader');

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$matched = false;

$routes = [];
require_once __DIR__ . '/../routes/web.php';

if (strpos($uri, '/api') === 0) {
    if (isset($routes[$method])){
        foreach ($routes[$method] as $routeUri => $controllerMethod) {
            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $routeUri);
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
                $matched = true;
                exit;
            }
        }
    }

    if(!$matched) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'Rota não encontrada',
            'data' => null
        ]);
    }
} else {
    $uriParts = explode('/', trim($uri, '/'));
    $viewName = ucfirst($uriParts[0]) . '.html'; // Usando a primeira parte para a view
    require_once __DIR__ . "/../app/Views/$viewName";
}