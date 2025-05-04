<?php

namespace App\Controllers;

use App\Models\Post;

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
}