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
        if (isset($_SESSION['user'])) {
            User::delete($_SESSION['user']);
            session_unset();
            session_destroy();
            return [
                'status' => 'success',
                'message' => 'Usuário deletado e sessão encerrada com sucesso!',
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
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageDir = __DIR__ . '/../../public/img/';
            if (!is_dir($imageDir)) {
                mkdir($imageDir, 0755, true); // Cria o diretório se não existir
            }
            
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('profile_', true) . '.' . $extension;
            $imagePath = $imageDir . $imageName;

            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

            $relativePath = '/img/' . $imageName; // Caminho relativo para salvar no banco

            // Atualiza a imagem do usuário logado
            User::updateProfile(['image' => $relativePath], $_SESSION['user']);

            return [
                'status' => 'success',
                'message' => 'Imagem atualizada com sucesso!',
                'data' => $relativePath
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Erro ao fazer upload da imagem!',
                'data' => null
            ];
        }
    }
}
