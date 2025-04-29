<?php

use App\Controllers\AuthController;
use App\Controllers\CommentController;
use App\Controllers\EstablishmentController;
use App\Controllers\PhotoController;
use App\Controllers\PostController;
use App\Controllers\ReactionController;
use App\Controllers\TagController;
use App\Controllers\TagPostController;
use App\Controllers\UserController;
use App\Models\User;

function route($uri, $controllerMethod, $method) {
    global $routes;

    if (isset($controllerMethod)) {
        $routes[$method][$uri] = $controllerMethod;
    } else {
        if (!isset($routes[$method])) {
            $routes[$method] = [];
        }
        array_push($routes[$method], $uri); 
    }
}

route('/login', null, 'PUBLICACCESS');
route('/registers', null, 'PUBLICACCESS');
route('/register-student', null, 'PUBLICACCESS');
route('/register-employee', null, 'PUBLICACCESS');
route('/register-coordinator', null, 'PUBLICACCESS');

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
    route('/api/tags', [TagController::class, 'index'], 'GET');
    route('/api/tags/{id}', [TagController::class, 'show'], 'GET');

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

    // Rotas de estabelecimentos
    route('/api/establishments', [EstablishmentController::class, 'index'], 'GET');
    route('/api/establishments/{id}', [EstablishmentController::class, 'show'], 'GET');

    route('/api/photos', [PhotoController::class, 'create'], 'POST');
    route('/api/user', [UserController::class, 'getUser'], 'GET');
    route('/api/get-posts-by-user-id', [PostController::class, 'getPostsByUserID'], 'GET');
    route('/api/updateProfile/{id}', [UserController::class, 'updateProfile'], 'PUT');
    route('/api/deletarAtual', [UserController::class, 'deletarAtual'], method: 'DELETE');
    route('/api/postsImage', [UserController::class, 'createImage'], 'POST');

    if (User::find($_SESSION['user'])[0]['access_level'] >= 3) {
        // Rotas de tags apenas para admins
        route('/api/tags', [TagController::class, 'create'], 'POST');
        route('/api/tags/{id}', [TagController::class, 'update'], 'PUT');
        route('/api/tags/{id}', [TagController::class, 'destroy'], 'DELETE');

        // Rotas de estabelecimentos apenas para admins
        route('/api/establishments', [EstablishmentController::class, 'create'], 'POST');
        route('/api/establishments/{id}', [EstablishmentController::class, 'update'], 'PUT');
        route('/api/establishments/{id}', [EstablishmentController::class, 'destroy'], 'DELETE');
    }
}