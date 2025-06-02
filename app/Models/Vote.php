<?php

namespace App\Models;

class Vote extends Model {
    public static function all() {
        $sql = 'SELECT * FROM votes';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM votes WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        array_unshift($request, $_SESSION['user']);

        $sql = 'INSERT INTO votes (user_id, post_id, value) VALUES (?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Voto criado com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE votes SET value = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Voto atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM votes WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Voto deletado com sucesso!',
            'data' => null
        ];
    }
}