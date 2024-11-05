<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;

function route($uri, $controllerMethod, $method) {
    global $routes;
    $routes[$method][$uri] = $controllerMethod;
}

route('/login', [AuthController::class, 'login'], 'POST');
route('/logout', [AuthController::class, 'logout'], 'POST');

route('/register', [UserController::class, 'create'], 'POST');
route('/users', [UserController::class, 'index'], 'GET');
route('/users/{id}', [UserController::class, 'show'], 'GET');
route('/users/{id}', [UserController::class, 'update'], 'PUT');
route('/users/{id}', [UserController::class, 'destroy'], 'DELETE');