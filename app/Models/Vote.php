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

        $sql = 'SELECT * from votes WHERE user_id = ? AND post_id = ?';
        $votes = self::query($sql, [$_SESSION['user'], $request['post_id']]);

        if (count($votes) != 0) {
            $vote = $votes[0];

            if ($request['value'] == $vote['value']) {
                Vote::delete($vote['id']);
                $sql = 'SELECT COUNT(*) AS total FROM votes WHERE post_id = ? AND value = ?';
                $upvotes = self::query($sql, [$request['post_id'], 1])[0]['total'];
                $downvotes = self::query($sql, [$request['post_id'], -1])[0]['total'];
                return [
                    'status' => 'success',
                    'message' => 'Voto modificado com sucesso!',
                    'data' => [
                        'id' => $vote['id'],
                        'upvotes' => $upvotes,
                        'downvotes' => $downvotes
                    ]
                ];
            } else {
                Vote::update([$request['value']], $vote['id']);
                $sql = 'SELECT COUNT(*) AS total FROM votes WHERE post_id = ? AND value = ?';
                $upvotes = self::query($sql, [$request['post_id'], 1])[0]['total'];
                $downvotes = self::query($sql, [$request['post_id'], -1])[0]['total'];
                return [
                    'status' => 'success',
                    'message' => 'Voto modificado com sucesso!',
                    'data' => [
                        'id' => $vote['id'],
                        'upvotes' => $upvotes,
                        'downvotes' => $downvotes
                    ]
                ];
            }
        } else {
            $sql = 'INSERT INTO votes (user_id, post_id, value) VALUES (?, ?, ?)';
            $id = self::query($sql, $request);

            $sql = 'SELECT COUNT(*) AS total FROM votes WHERE post_id = ? AND value = ?';
            $upvotes = self::query($sql, [$request['post_id'], 1])[0]['total'];
            $downvotes = self::query($sql, [$request['post_id'], -1])[0]['total'];
            return [
                'status' => 'success',
                'message' => 'Voto criado com sucesso!',
                'data' => [
                    'id' => $id,
                    'upvotes' => $upvotes,
                    'downvotes' => $downvotes
                ]
            ];
        }
    }

    public static function update($request, $id) {
        $sql = 'UPDATE votes SET value = ? WHERE id = ?';
        array_push($request, $id);
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