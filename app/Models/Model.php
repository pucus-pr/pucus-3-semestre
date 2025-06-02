<?php

namespace App\Models;

require_once __DIR__ . '/../../config/config.php';

class Model {
    public static function query($sql, $params) {
        $conn = new \mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        $sql = $conn->prepare($sql);
        $sql->execute(array_values($params));
        
        $results = $sql->get_result();

        if (is_object($results)) {
            $results = $results->fetch_all(MYSQLI_ASSOC);
        } elseif (is_bool($results)) {
            $results = $conn->insert_id;
        } elseif($params){
            $stmt = $conn->prepare($sql);
            $types = str_repeat('s', count($params)); 
            $stmt->bind_param($types, ...$params);
        }
        $sql->close();
        $conn->close();
        return $results;
    }
}