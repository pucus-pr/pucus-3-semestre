<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use ErrorException;
use Exception;
use App\Models\Model;

class AuthController
{
    public function login()
    {
        try {
            $request = $_POST;

            if (!isset($request['email']) or !isset($request['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Usuário inválido',
                    'data' => null
                ];
            }

            $user = User::where('email', '=', $request['email']);

            if (isset($user[0])) {
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

    public function logout()
    {
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
    public function requestPResetEmail(): array
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            extract($_POST);
            $users = Model::query("SELECT * FROM users WHERE email = ?", [$email]);
            try {
                if (!empty($users)) {
                    $users = $users[0];
                    $resetData = $this->generatePRToken();
                    $token = $resetData['token'];
                    $expires = $resetData['expires'];
                    Model::query("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?", [$token, $expires, $email]);

                    $reset_link = "http://pucus.com/resetpassword?token={$token}";
                    $emailController = new EmailController();
                    $emailController->sendPResetEmail($email, $reset_link);
                    return [
                        'status' => 'success',
                        'message' => 'Email de redefinição de senha enviado!'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'E-mail não encontrado!'
                    ];
                }
            } catch (Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Erro: ' . $e->getMessage()
                ];

            }
        }
    }
    public function generatePRToken(): array
    {
        $token = bin2hex((random_bytes(16)));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        return [
            'token' => $token,
            'expires' => $expires
        ];

    }
    public function resetPassword(): array
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['token'], $_POST['new_password'])) {
                return [
                    'status' => 'error',
                    'message' => 'Token ou senha não fornecidos.'
                ];
            }
            $token = $_POST['token'];
            $new_password = $_POST['new_password'];
            try {
                $userModel = new User();
                $user = $userModel->getUserbyResetT($token);
                if ($user && strtotime($user['reset_expires']) > time()) {
                    $hashedPasword = password_hash($new_password, PASSWORD_BCRYPT);
                    $userModel->updatePasswordClearT($user['id'], $hashedPasword);
                    return [
                        'status' => 'success',
                        'message' => 'Senha redefinida com sucesso!'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Token inválido ou expirado!'
                    ];
                }
            } catch (Exception $e) {
                return [
                    'status' => 'error',
                    'message' => 'Erro: ' . $e->getMessage()

                ];
            }
        }
        return [
            'status' => 'error',
            'message' => 'Método Inválido.'
        ];
    }
}