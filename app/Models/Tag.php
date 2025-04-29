<?php

namespace App\Models;

class Tag extends Model {
    public static function all() {
        $sql = 'SELECT * FROM tags';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM tags WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO tags (name) VALUES (?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Tag criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE tags SET name = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Tag atualizada com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM tags WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Tag deletada com sucesso!',
            'data' => null
        ];
    }
}