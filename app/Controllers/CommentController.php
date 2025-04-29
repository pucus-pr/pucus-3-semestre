<?php

namespace App\Controllers;

use App\Models\Comment;

class CommentController {
    public function index() {
        return Comment::all();
    }
    
    public function show($id) {
        return Comment::find($id);
    }

    public function create() {
        return Comment::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Comment::update($parsedData, $id);
    }

    public function destroy($id) {
        return Comment::delete($id);
    }
}