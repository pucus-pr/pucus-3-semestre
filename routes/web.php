<?php

use App\Controllers\AuthController;
use App\Controllers\NotificationController;
use App\Controllers\PostController;
use App\Controllers\TagController;
use App\Controllers\TagPostController;
use App\Controllers\UserController;
use App\Controllers\VoteController;
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

route('/api/login', [AuthController::class, 'login'], 'POST');
route('/api/register', [UserController::class, 'create'], 'POST');

route('/api/requestpasswordreset', [AuthController::class, 'requestPResetEmail'], 'POST');
route('/api/passwordreset', [AuthController::class, 'resetPassword'], 'POST');


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
    route('/api/posts/{tag}', [PostController::class, 'destroy'], 'GET');
    route('/api/statements', [PostController::class, 'allStatements'], 'GET');

    // Rotas de tags-posts
    route('/api/tags-posts', [TagPostController::class, 'create'], 'POST');
    route('/api/tags-posts', [TagPostController::class, 'index'], 'GET');
    route('/api/tags-posts/{id}', [TagPostController::class, 'show'], 'GET');
    route('/api/tags-posts/{id}', [TagPostController::class, 'update'], 'PUT');
    route('/api/tags-posts/{id}', [TagPostController::class, 'destroy'], 'DELETE');

    // Rotas de votes
    route('/api/votes', [VoteController::class, 'create'], 'POST');
    route('/api/votes', [VoteController::class, 'index'], 'GET');
    route('/api/votes/{id}', [VoteController::class, 'show'], 'GET');
    route('/api/votes/{id}', [VoteController::class, 'update'], 'PUT');
    route('/api/votes/{id}', [VoteController::class, 'destroy'], 'DELETE');

    // Rotas de notifications
    route('/api/notifications', [NotificationController::class, 'create'], 'POST');
    route('/api/notifications', [NotificationController::class, 'index'], 'GET');
    route('/api/notifications/{id}', [NotificationController::class, 'show'], 'GET');
    route('/api/notifications/{id}', [NotificationController::class, 'update'], 'PUT');
    route('/api/notifications/{id}', [NotificationController::class, 'destroy'], 'DELETE');

    // Rotas diversas
    route('/api/user', [UserController::class, 'getUser'], 'GET');
    route('/api/get-posts-by-user-id', [PostController::class, 'getPostsByUserID'], 'GET');
    route('/api/updateProfile', [UserController::class, 'updateProfile'], 'POST');
    route('/api/deletarAtual', [UserController::class, 'deletarAtual'], method: 'DELETE');
    route('/api/postsImage', [UserController::class, 'createImage'], 'POST');
    route('/api/updatePostTags/{id}', [TagPostController::class, 'updatePostTags'], 'PUT');

    if (User::find($_SESSION['user'])[0]['access_level'] >= 3) {
        // Rotas de tags apenas para admins
        route('/api/tags', [TagController::class, 'create'], 'POST');
        route('/api/tags/{id}', [TagController::class, 'update'], 'PUT');
        route('/api/tags/{id}', [TagController::class, 'destroy'], 'DELETE');

        // Rotas de posts apenas para admins
        route('/api/statements', [PostController::class, 'createStatement'], 'POST');
        route('/api/allConcluded', [PostController::class, 'allConcludedPosts'], 'GET');
        route('/api/confirmPost/{id}', [PostController::class, 'confirmPost'], 'PUT');
        route('/api/denyPost/{id}', [PostController::class, 'denyPost'], 'PUT');
    }
}