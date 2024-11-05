<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class UserController {
    public function index() {
        return User::all();
    }
    
    public function show($id) {
        return User::find($id);
    }

    public function create() {
        User::create($_POST);
    }
}