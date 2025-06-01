<?php

namespace App\Models;

class Notification extends Model {
    public static function all() {
        $sql = 'SELECT * FROM notifications';
        return self::query($sql, []);
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM notifications WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request) {
        $sql = 'INSERT INTO notifications (user_id, title, message, type) VALUES (?, ?, ?, ?)';
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Notificação criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }

    public static function update($request, $id) {
        $sql = 'UPDATE notifications SET read_at = NOW() WHERE id = ?';
        array_push($request, $id);
        $id = self::query($sql, $request);
        return [
            'status' => 'success',
            'message' => 'Notificação atualizada com sucesso!',
            'data' => null
        ];
    }

    public static function delete($id) {
        $sql = 'DELETE FROM notifications WHERE id = ?';
        self::query($sql, [$id]);
        return [
            'status' => 'success',
            'message' => 'Notificação deletada com sucesso!',
            'data' => null
        ];
    }
}