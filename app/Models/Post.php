<?php

namespace App\Models;

class Post extends Model {
    public static function all() {
        $sql = 'SELECT * FROM posts';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM posts WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO posts (user_id, text, image, tag_id, ) VALUES (?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Postagem criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE posts SET name = ?, email = ?, password = ?, identifier = ?, access_level = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Postagem atualizada com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM posts WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Postagem deletada com sucesso!',
            'data' => null
        ];
    }
}