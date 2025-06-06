<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
    // Retorna todos os usuários
    public function index() {
        return User::all();
    }
    
    public function show($id) {
        $user = User::find($id)[0];
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
                'profilePicture' => $user['image'],
                'access_level' => $user['access_level'],
                'email' => $user['email']
            ]
        ];
    }

    public function updateProfile() {
        return User::updateProfile($_POST, $_FILES);
    }

    public function deletarAtual() {
        User::delete($_SESSION['user']);

        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();
            return [
                'status' => 'success',
                'message' => 'Usuário deslogado com sucesso!',
                'data' => null
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Usuário não logado!',
                'data' => null
            ];
        }
    }
}
