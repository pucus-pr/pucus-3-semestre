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
        array_unshift($request, $_SESSION['user']);

        $sql = 'INSERT INTO reactions (user_id, reactable_type, reactable_id, positive) VALUES (?, ?, ?, ?)';
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
        array_unshift($request, $_SESSION['user']);

        $sql = 'UPDATE reactions SET user_id = ?, reactable_type = ?, reactable_id = ?, positive = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
            
        return [
            'status' => 'success',
            'message' => 'Reação atualizada com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM reactions WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Reação deletada com sucesso!',
            'data' => null
        ];
    }
}