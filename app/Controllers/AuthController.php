<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\User;
use ErrorException;
use Exception;

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
    public function requestPResetEmail(): array {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            extract($_POST);
            $smtp = $conn->prepare("SELECT * FROM users where email = ?");
            $smtp->bind_param('s', $email);
            $smtp->execute();
            $result = $smtp->get_result();
            
            try{
                if ($result->num_rows > 0){
                $user = $result->fetch_assoc();
                $resetData = $this->generatePRToken();
                $token = $resetData['token'];
                $expires = $resetData['expires'];
                $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? where email = ?");
                $update->bind_param('sss', $token, $expires, $email);
                $update->execute();
                $reset_link = "https://pucus.com/resetpassword?token={$token}";
                $emailController = new EmailController();
                $emailController->sendPResetEmail($email, $reset_link);
                return [
                    'status' => 'sucess',
                    'message' => 'Email de redefinição de senha enviado!'
                ];
            }
            
            else{
                return[
                    'status' => 'error',
                    'message' => 'E-mail não encontrado!'
                ];
            }
            } 
            
            catch (Exception $e){
                return[
                    'status' => 'error',
                    'message' => 'Erro: ' . $e->getMessage()
                ];

            }
            }
        }
        public function generatePRToken(): array{
            $token = bin2hex((random_bytes(16)));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            return[
                'token' => $token,
                'expires' => $expires
            ];

        }
        public function resetPassword(): array{
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                extract($_POST);
                $token = $_GET['token'];
                $conn = new\mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()");
                $stmt->execute();
                $result = $stmt->get_result();

                try{
                    if ($result->num_rows > 0){
                    $user = $result->fetch_assoc();
                    $hashPassword = password_hash($new_password, PASSWORD_BCRYPT);
                    $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
                    $update->bind_param('s', $hashPassword, $user['id']);
                    $update->execute();
                    return [
                        'status' => 'success',
                        'message' => 'Senha redefinida com sucesso!'
                    ];
                }
                else {
                    return[
                        'status' => 'error',
                        'message' => 'Token inválido ou expirado!'
                    ];
                }
                }  catch (Exception $e){
                    return[
                        'status' => 'error',
                        'message' => 'Erro: ' . $e->getMessage()
                    ];

                }
                
        
            }
            
            }
        
        }