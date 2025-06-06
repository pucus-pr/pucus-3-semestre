<?php

namespace App\Controllers;

use App\Models\Vote;

class VoteController {
    public function index() {
        return Vote::all();
    }
    
    public function show($id) {
        return Vote::find($id);
    }

    public function create() {
        return Vote::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Vote::update($parsedData, $id);
    }

    public function destroy($id) {
        return Vote::delete($id);
    }
}