<?php

use App\Controllers\AuthController;
use App\Controllers\CommentController;
use App\Controllers\PostController;
use App\Controllers\ReactionController;
use App\Controllers\TagController;
use App\Controllers\TagPostController;
use App\Controllers\UserController;

function route($uri, $controllerMethod, $method) {
    global $routes;
    $routes[$method][$uri] = $controllerMethod;
}

route('/login', [AuthController::class, 'login'], 'POST');
route('/register', [UserController::class, 'create'], 'POST');

if ($_SESSION['user']) {
    // Rotas de usuários
    route('/logout', [AuthController::class, 'logout'], 'POST');
    route('/users', [UserController::class, 'index'], 'GET');
    route('/users/{id}', [UserController::class, 'show'], 'GET');
    route('/users/{id}', [UserController::class, 'update'], 'PUT');
    route('/users/{id}', [UserController::class, 'destroy'], 'DELETE');

    // Rotas de tags
    route('/tags', [TagController::class, 'create'], 'POST');
    route('/tags', [TagController::class, 'index'], 'GET');
    routex('/tags/{id}', [TagController::class, 'show'], 'GET');
    route('/tags/{id}', [TagController::class, 'update'], 'PUT');
    route('/tags/{id}', [TagController::class, 'destroy'], 'DELETE');

    // Rotas de posts
    route('/posts', [PostController::class, 'create'], 'POST');
    route('/posts', [PostController::class, 'index'], 'GET');
    route('/posts/{id}', [PostController::class, 'show'], 'GET');
    route('/posts/{id}', [PostController::class, 'update'], 'PUT');
    route('/posts/{id}', [PostController::class, 'destroy'], 'DELETE');

    // Rotas de tags-posts
    route('/tags-posts', [TagPostController::class, 'create'], 'POST');
    route('/tags-posts', [TagPostController::class, 'index'], 'GET');
    route('/tags-posts/{id}', [TagPostController::class, 'show'], 'GET');
    route('/tags-posts/{id}', [TagPostController::class, 'update'], 'PUT');
    route('/tags-posts/{id}', [TagPostController::class, 'destroy'], 'DELETE');

    // Rotas de reações
    route('/reactions', [ReactionController::class, 'create'], 'POST');
    route('/reactions', [ReactionController::class, 'index'], 'GET');
    route('/reactions/{id}', [ReactionController::class, 'show'], 'GET');
    route('/reactions/{id}', [ReactionController::class, 'update'], 'PUT');
    route('/reactions/{id}', [ReactionController::class, 'destroy'], 'DELETE');

    // Rotas de comentários
    route('/comments', [CommentController::class, 'create'], 'POST');
    route('/comments', [CommentController::class, 'index'], 'GET');
    route('/comments/{id}', [CommentController::class, 'show'], 'GET');
    route('/comments/{id}', [CommentController::class, 'update'], 'PUT');
    route('/comments/{id}', [CommentController::class, 'destroy'], 'DELETE');
}