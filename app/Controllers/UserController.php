<?php

namespace App\Controllers;

use App\Models\User;

class UserController {
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
                'profilePicture' => $user['image']
            ]
        ];
    }

    public function updateProfile($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return User::updateProfile($parsedData, $id);
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

    public function createImage() {
        $imageDir = __DIR__ . '/../../public/img/';
        $imageName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imagePath = $imageDir . $imageName;

        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

        $_POST['image'] = $imagePath;

        User::create($_POST);
    }
}