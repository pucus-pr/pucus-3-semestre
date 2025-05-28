<?php

namespace App\Controllers;

use App\Models\Tag;

class TagController {
    // Retorna todos as tags
    public function index() {
        return Tag::all();
    }
    
    public function show($id) {
        return Tag::find($id);
    }

    public function create() {
        return Tag::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Tag::update($parsedData, $id);
    }

    public function destroy($id) {
        return Tag::delete($id);
    }
}
