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

route('/api/login', [AuthController::class, 'login'], 'POST');
route('/api/register', [UserController::class, 'create'], 'POST');

if (isset($_SESSION['user'])) {
    // Rotas de usuários
    route('/api/logout', [AuthController::class, 'logout'], 'POST');
    route('/api/users', [UserController::class, 'index'], 'GET');
    route('/api/users/{id}', [UserController::class, 'show'], 'GET');
    route('/api/users/{id}', [UserController::class, 'update'], 'PUT');
    route('/api/users/{id}', [UserController::class, 'destroy'], 'DELETE');

    // Rotas de tags
    route('/api/tags', [TagController::class, 'create'], 'POST');
    route('/api/tags', [TagController::class, 'index'], 'GET');
    route('/api/tags/{id}', [TagController::class, 'show'], 'GET');
    route('/api/tags/{id}', [TagController::class, 'update'], 'PUT');
    route('/api/tags/{id}', [TagController::class, 'destroy'], 'DELETE');

    // Rotas de posts
    route('/api/posts', [PostController::class, 'create'], 'POST');
    route('/api/posts', [PostController::class, 'index'], 'GET');
    route('/api/posts/{id}', [PostController::class, 'show'], 'GET');
    route('/api/posts/{id}', [PostController::class, 'update'], 'PUT');
    route('/api/posts/{id}', [PostController::class, 'destroy'], 'DELETE');

    // Rotas de tags-posts
    route('/api/tags-posts', [TagPostController::class, 'create'], 'POST');
    route('/api/tags-posts', [TagPostController::class, 'index'], 'GET');
    route('/api/tags-posts/{id}', [TagPostController::class, 'show'], 'GET');
    route('/api/tags-posts/{id}', [TagPostController::class, 'update'], 'PUT');
    route('/api/tags-posts/{id}', [TagPostController::class, 'destroy'], 'DELETE');

    // Rotas de reações
    route('/api/reactions', [ReactionController::class, 'create'], 'POST');
    route('/api/reactions', [ReactionController::class, 'index'], 'GET');
    route('/api/reactions/{id}', [ReactionController::class, 'show'], 'GET');
    route('/api/reactions/{id}', [ReactionController::class, 'update'], 'PUT');
    route('/api/reactions/{id}', [ReactionController::class, 'destroy'], 'DELETE');

    // Rotas de comentários
    route('/api/comments', [CommentController::class, 'create'], 'POST');
    route('/api/comments', [CommentController::class, 'index'], 'GET');
    route('/api/comments/{id}', [CommentController::class, 'show'], 'GET');
    route('/api/comments/{id}', [CommentController::class, 'update'], 'PUT');
    route('/api/comments/{id}', [CommentController::class, 'destroy'], 'DELETE');
}