<?php

namespace App\Models;

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
        try {
            $sql = 'INSERT INTO users (name, identifier, email, password, access_level, image) VALUES (?, ?, ?, ?, ?, ?)';
            $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT);
            $id = self::query($sql, $request);
            return [
                'status' => 'success',
                'message' => 'Usuário criado com sucesso!',
                'data' => [
                    'id' => $id
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao criar o usuário!',
                'data' => $e->getMessage()
            ];
        }
    }

    public static function update($request, $id) {
        $sql = 'UPDATE users SET name = ?, email = ?, password = ?, identifier = ?, access_level = ?, image = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Usuário atualizado com sucesso!',
            'data' => $id
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM users WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Usuário deletado com sucesso!',
            'data' => null
        ];
    }

    public static function where($column, $operator, $value) {
        $sql = "SELECT * FROM USERS WHERE $column $operator ?";
        return self::query($sql, [$value]);
    }

    public static function updateProfile($request, $id) {
        $sql = "UPDATE users SET name = ?, identifier = ?, image = ? WHERE id = ?";
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Usuário atualizado com sucesso!',
            'data' => $id
        ];
    }
}