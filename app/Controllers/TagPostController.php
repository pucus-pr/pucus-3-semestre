<?php

namespace App\Controllers;

use App\Models\TagPost;

class TagPostController {
    public function index() {
        return TagPost::all();
    }
    
    public function show($id) {
        return TagPost::find($id);
    }

    public function create() {
        return TagPost::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return TagPost::update($parsedData, $id);
    }

    public function destroy($id) {
        return TagPost::delete($id);
    }

    public function updatePostTags($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        $allTagPosts = $this->index();

        foreach ($allTagPosts as $tagPost) {
            if ($tagPost['post_id'] == $id) {
                TagPost::delete($tagPost['id']);
            }
        }

        $tags = $parsedData['tags'];

        foreach ($tags as $tag) {
            TagPost::create([$id, $tag]);
        }

        return $this->index();
    }
}