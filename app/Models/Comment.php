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
        array_unshift($request, $_SESSION['user']);
        
        $sql = 'INSERT INTO comments (user_id, commentable_type, commentable_id, message) VALUES (?, ?, ?, ?)';
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
        array_unshift($request, $_SESSION['user']);

        $sql = 'UPDATE comments SET user_id = ?, commentable_type = ?, commentable_id = ?, message = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        
        return [
            'status' => 'success',
            'message' => 'Comentário atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM comments WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Comentário deletado com sucesso!',
            'data' => null
        ];
    }
}