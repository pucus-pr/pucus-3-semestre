<?php

namespace App\Controllers;

use App\Models\Establishment;

class EstablishmentController {
    public function index() {
        return Establishment::all();
    }
    
    public function show($id) {
        return Establishment::find($id);
    }

    public function create() {
        return Establishment::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Establishment::update($parsedData, $id);
    }

    public function destroy($id) {
        return Establishment::delete($id);
    }
}