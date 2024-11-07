<?php

namespace App\Models;

class Comment extends Model {
    public static function all() {
        $sql = 'SELECT * FROM comments';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM comments WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO comments (user_id, post_id, message) VALUES (?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Comentário criado com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE users SET user_id = ?, post_id = ?, message = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Comentário atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM users WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Comentário deletado com sucesso!',
            'data' => null
        ];
    }
}