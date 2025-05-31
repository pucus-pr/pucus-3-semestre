<?php

namespace App\Models;

class Post extends Model {
    public static function all() {
        $user = User::find($_SESSION['user'])[0];
    
        // Mapeamento de identifier para tag_id
        $identifierTagMap = [
            'Segurança' => 1,
            'TI' => 2,
            'Limpeza' => 3,
            'Estrutura' => 4
        ];
    
        // Base da query
        $sql = '
            SELECT posts.*, 
                users.name AS user_name, 
                users.image AS user_image,
                GROUP_CONCAT(tags_posts.tag_id) AS tags,
                (
                    SELECT COUNT(*) FROM votes 
                    WHERE votes.post_id = posts.id AND votes.value = 1
                ) AS upvotes,
                (
                    SELECT COUNT(*) FROM votes 
                    WHERE votes.post_id = posts.id AND votes.value = -1
                ) AS downvotes
            FROM posts
            JOIN users ON posts.user_id = users.id
            LEFT JOIN tags_posts ON posts.id = tags_posts.post_id
        ';
    
        $params = [];
        $where = ['posts.type = 0']; // Inicia com filtro por type
    
        // Adiciona filtro se o usuário for de nível 2
        if ($user['access_level'] == 2) {
            $tagConditions = [];
    
            if (isset($identifierTagMap[$user['identifier']])) {
                $tagConditions[] = 'tag_id = ?';
                $params[] = $identifierTagMap[$user['identifier']];
            }
    
            // Sempre incluir Alerta Geral (tag 5)
            $tagConditions[] = 'tag_id = ?';
            $params[] = 5;
    
            $where[] = 'posts.id IN (
                SELECT post_id FROM tags_posts WHERE ' . implode(' OR ', $tagConditions) . '
            )';
        }
    
        // Se houver condições, adiciona WHERE
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
    
        // Finaliza a query
        $sql .= '
            GROUP BY posts.id
            ORDER BY posts.id DESC
        ';
    
        $posts = self::query($sql, $params);
    
        // Converter a string de tags em array
        foreach ($posts as &$post) {
            $post['tags'] = $post['tags'] ? array_map('intval', explode(',', $post['tags'])) : [];
        }
    
        return $posts;
    }

    public static function allStatements() {
        $user = User::find($_SESSION['user'])[0];
    
        // Mapeamento de identifier para tag_id
        $identifierTagMap = [
            'Segurança' => 1,
            'TI' => 2,
            'Limpeza' => 3,
            'Estrutura' => 4
        ];
    
        // Base da query
        $sql = '
            SELECT posts.*, 
                users.name AS user_name, 
                users.image AS user_image,
                GROUP_CONCAT(tags_posts.tag_id) AS tags,
                (
                    SELECT COUNT(*) FROM votes 
                    WHERE votes.post_id = posts.id AND votes.value = 1
                ) AS upvotes,
                (
                    SELECT COUNT(*) FROM votes 
                    WHERE votes.post_id = posts.id AND votes.value = -1
                ) AS downvotes
            FROM posts
            JOIN users ON posts.user_id = users.id
            LEFT JOIN tags_posts ON posts.id = tags_posts.post_id
        ';
    
        $params = [];
        $where = ['posts.type = 1']; // Inicia com filtro por type
    
        // Adiciona filtro se o usuário for de nível 2
        if ($user['access_level'] == 2) {
            $tagConditions = [];
    
            if (isset($identifierTagMap[$user['identifier']])) {
                $tagConditions[] = 'tag_id = ?';
                $params[] = $identifierTagMap[$user['identifier']];
            }
    
            // Sempre incluir Alerta Geral (tag 5)
            $tagConditions[] = 'tag_id = ?';
            $params[] = 5;
    
            $where[] = 'posts.id IN (
                SELECT post_id FROM tags_posts WHERE ' . implode(' OR ', $tagConditions) . '
            )';
        }
    
        // Se houver condições, adiciona WHERE
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
    
        // Finaliza a query
        $sql .= '
            GROUP BY posts.id
            ORDER BY posts.id DESC
        ';
    
        $posts = self::query($sql, $params);
    
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

    public static function createStatement($request) {
        array_unshift($request, $_SESSION['user']);

        array_push($request, 1);

        $sql = 'INSERT INTO posts (user_id, text, type) VALUES (?, ?, ?, ?)';
        $id = self::query($sql, $request);

        return [
            'status' => 'success',
            'message' => 'Postagem criada com sucesso!',
            'data' => [
                'id' => $id
            ]
        ];
    }
}