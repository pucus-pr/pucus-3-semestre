<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function login() {
        $request = $_POST;
        $user = User::where('email', '=', $request['email'])[0];
        if (password_verify($request['password'], $user['password'])) {
            $_SESSION['user'] = $user['id'];
            return [
                'status' => 'success',
                'message' => 'Usuário logado com sucesso!',
                'data' => null
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Usuário inválido!',
                'data' => null
            ];
        }
    }

    public function logout() {
        if (isset($_SESSION['user'])) {
            $_SESSION['user'] = null;
            return [
                'status' => 'success',
                'message' => 'Usuário deslogado com sucesso!',
                'data' => null
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Usuário inexistente!',
                'data' => null
            ];
        }
    }
}