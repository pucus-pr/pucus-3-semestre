<?php

namespace App\Models;

class Post extends Model {
    public static function all() {
        $sql = '
            SELECT posts.*, 
                   users.name AS user_name, 
                   users.image AS user_image,
                   GROUP_CONCAT(tags_posts.tag_id) AS tags
            FROM posts
            JOIN users ON posts.user_id = users.id
            LEFT JOIN tags_posts ON posts.id = tags_posts.post_id
            GROUP BY posts.id
            ORDER BY posts.id DESC
        ';
    
        $posts = self::query($sql, []);
    
        // Converter a string de tags em array
        foreach ($posts as &$post) {
            $post['tags'] = $post['tags'] ? array_map('intval', explode(',', $post['tags'])) : [];
        }
    
        return $posts;
    }
    
    public static function find($id) {
        $sql = 'SELECT * FROM posts WHERE id = ?';
        return self::query($sql, [$id]);
    }

    public static function create($request, $image) {
        array_unshift($request, $_SESSION['user']);

        $imagePath = Photo::create($image);

        array_push($request, $imagePath);

        $tags = $request['tags'];
        unset($request['tags']);

        $sql = 'INSERT INTO posts (user_id, text, image) VALUES (?, ?, ?)';
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

    public static function allByUserId($userId) {
        $sql = '
            SELECT posts.*, 
                   users.name AS user_name, 
                   users.image AS user_image,
                   GROUP_CONCAT(tags_posts.tag_id) AS tags
            FROM posts
            JOIN users ON posts.user_id = users.id
            LEFT JOIN tags_posts ON posts.id = tags_posts.post_id
            WHERE posts.user_id = ?
            GROUP BY posts.id
            ORDER BY posts.id DESC
        ';
    
        $posts = self::query($sql, [$userId]);
    
        // Converter a string de tags em array
        foreach ($posts as &$post) {
            $post['tags'] = $post['tags'] ? array_map('intval', explode(',', $post['tags'])) : [];
        }
    
        return $posts;
    }
}