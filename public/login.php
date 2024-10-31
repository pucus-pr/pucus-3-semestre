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
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $sql = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $sql->bind_param('s', $email);
    $sql->execute();
    $result = $sql->get_result();

    while ($row = $result->fetch_assoc()) {
        $storedEmail = $row['email'];
        $storedPassword = $row['password'];

        if ($password == $storedPassword) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Usuário logado com sucesso',
                'data' => null
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Falha ao logar o usuário',
                'data' => null
            ]);
        }
    }
}

$conn->close();