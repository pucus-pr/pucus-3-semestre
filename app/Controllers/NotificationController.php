<?php

namespace App\Controllers;

use App\Models\Notification;

class NotificationController {
    public function index() {
        return Notification::all();
    }
    
    public function show($id) {
        return Notification::find($id);
    }

    public function create() {
        return Notification::create($_POST);
    }

    public function update($id) {
        $data = file_get_contents("php://input");
        parse_str($data, $parsedData);

        return Notification::update($parsedData, $id);
    }

    public function destroy($id) {
        return Notification::delete($id);
    }
}