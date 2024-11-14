<?php

namespace App\Models;

class Establishment extends Model {
    public static function all() {
        $sql = 'SELECT * FROM establishments';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM establishments WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO establishments (name, description1, description2) VALUES (?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Estabelecimento criado com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE establishments SET name = ?, description1 = ?, description2 = ? WHERE id = ?';
        $request['id'] = $id;
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Estabelecimento atualizado com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM establishments WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Estabelecimento deletado com sucesso!',
            'data' => null
        ];
    }
}