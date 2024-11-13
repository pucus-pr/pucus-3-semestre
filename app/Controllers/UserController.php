<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    public function index() {
        return User::all();
    }
    
    public function show($id) {
        return User::find($id);
    }

    public function create() {
        return User::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return User::update($parsedData, $id);
    }

    public function destroy($id) {
        return User::delete($id);
    }

    public function getUser() {
        $user = User::find($_SESSION['user'])[0];
        return [
            'status' => 'success',
            'message' => 'Usuário retornado com sucesso',
            'data' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'identifier' => $user['identifier'],
                'profilePicture' => $user['image']
            ]
        ];
    }

    public function updateProfile($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return User::updateProfile($parsedData, $id);
    }
}