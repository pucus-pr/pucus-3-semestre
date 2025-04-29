<?php

namespace App\Models;

class TagPost extends Model {
    public static function all() {
        $sql = 'SELECT * FROM tags_posts';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM tags_posts WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO tags_posts (post_id, tag_id) VALUES (?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Tag post criado com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE tags_posts SET post_id = ?, tag_id = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Tag post atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM tags_posts WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Tag post deletado com sucesso!',
            'data' => null
        ];
    }
}