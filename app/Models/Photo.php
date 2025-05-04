<?php

namespace App\Models;

class Photo extends Model {
    public static function create($image) {
        $imageDir = __DIR__ . '/../../public/img/';
        $imageName = uniqid() . '.' . pathinfo($image['file']['name'], PATHINFO_EXTENSION);
        $imagePath = $imageDir . $imageName;

        move_uploaded_file($_FILES['file']['tmp_name'], $imagePath);

        return '/img/' . $imageName;
    }
}