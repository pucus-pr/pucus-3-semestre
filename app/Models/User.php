<?php

namespace App\Models;

use Exception;

class User extends Model {
    public static function all() {
        $sql = 'SELECT * FROM users';
        return self::query($sql, []);
    }

    public static function find($id) {
        $sql = 'SELECT * FROM users WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)';
        self::query($sql, $request);
    }
}