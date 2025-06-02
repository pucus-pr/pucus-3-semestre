<?php

namespace App\Models;

require_once __DIR__ . '/../../config/config.php';

class Model {
    public static function query($sql, $params) {
        $conn = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }

        if (!empty($params)) {
            $types = str_repeat('s', count($params)); // Assume tudo string
            $stmt->bind_param($types, ...array_values($params)); // Sem nomes!
        }

        $stmt->execute();
        $results = $stmt->get_result();

        if (is_object($results)) {
            $results = $results->fetch_all(MYSQLI_ASSOC);
        } elseif (is_bool($results)) {
            $results = $conn->insert_id;
        }

        $stmt->close();
        $conn->close();

        return $results;
    }
}