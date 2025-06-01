<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Notification;

class PostController {
    public function index() {
        return Post::all();
    }
    
    public function show($id) {
        return Post::find($id);
    }

    public function create() {
        return Post::create($_POST, $_FILES);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Post::update($parsedData, $id);
    }

    public function destroy($id) {
        return Post::delete($id);
    }

    public function getPostsByUserID() {
        $posts = Post::allByUserId($_SESSION['user']);

        return [
            'status' => 'success',
            'message' => 'Posts retornados com sucesso',
            'data' => $posts
        ];
    }

    public function allStatements() {
        return Post::allStatements();
    }

    public function createStatement() {
        return Post::createStatement($_POST);
    }

    public function allConcludedPosts() {
        return Post::allConcluded($_POST);
    }

    public function confirmPost($id) {
        $post = self::show($id)[0];

        Notification::create([$post['user_id'], 'Postagem Confirmada', 'Sua postagem foi analisada pelos coordenadores e foi confirmada sua resolução! Obrigado pela denúncia.', 0], $id);

        return Post::confirm($id);
    }

    public function denyPost($id) {
        return Post::deny($id);
    }
}