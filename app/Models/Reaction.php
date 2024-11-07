<?php

namespace App\Models;

class Reaction extends Model {
    public static function all() {
        $sql = 'SELECT * FROM reactions';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM reactions WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO reactions (user_id, post_id, positive) VALUES (?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Reação criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE reactions SET user_id = ?, post_id = ?, positive = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Usuário atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM reactions WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Usuário deletado com sucesso!',
            'data' => null
        ];
    }
}