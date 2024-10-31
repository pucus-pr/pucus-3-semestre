<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'pucus');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$conn) {
    die('Falha na conexão: '.mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (isset($_POST['name'])) {
        try {
            $sql = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $sql->bind_param('sss', $name, $email, $password);
            if ($sql->execute()) {
                $sql->close();

                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Usuário criado com sucesso!',
                    'data' => null
                ]);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao criar o usuário',
                'data' => $e->getMessage()
            ]);
        }
    }
}

$conn->close();