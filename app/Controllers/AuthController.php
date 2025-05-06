<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function login() {
        try {
            $request = $_POST;

            if(!isset($request['email']) or !isset($request['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Usuário inválido',
                    'data' => null
                ];
            }

            $user = User::where('email', '=', $request['email']);

            if(isset($user[0])) {
                $user = $user[0];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Usuário não existe!',
                    'data' => null
                ];
            }
            
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
                    'message' => 'Senha incorreta!',
                    'data' => null
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Usuário inválido!',
                'data' => $e->getMessage()
            ];
        }
    }

    public function logout() {
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