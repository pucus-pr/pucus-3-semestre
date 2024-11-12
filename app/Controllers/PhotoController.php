<?php

namespace App\Controllers;

use App\Models\TagPost;

class PhotoController {
    public function create() {
        $imageDir = __DIR__ . '/../../public/img/';
        $imageName = uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imagePath = $imageDir . $imageName;

        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);

        return $imagePath;
    }
}