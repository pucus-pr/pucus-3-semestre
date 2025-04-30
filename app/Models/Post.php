<?php

namespace App\Models;

use App\Controllers\TagController;

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
        array_unshift($request, $_SESSION['user']);

        $tags = $request['tags'];
        unset($request['tags']);

        $sql = 'INSERT INTO posts (user_id, text) VALUES (?, ?)';
        $id = self::query($sql, $request);

        foreach($tags as $tag) {
            TagPost::create([$id, $tag]);
        }

        return [
            'status' => 'success',
            'message' => 'Postagem criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        array_unshift($request, $_SESSION['user']);

        $sql = 'UPDATE posts SET user_id = ?, text = ?, type = ?, image = ? WHERE id = ?';
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

    public static function where($column, $operator, $value) {
        $sql = "SELECT * FROM posts WHERE $column $operator ?";
        return self::query($sql, [$value]);
    }
}