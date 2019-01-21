<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register() {
        return view('user.register');
    }
    public function create() {
        echo 'create';
    }

    public function login() {
        echo 'login';
//        return view();
    }

    public function logging() {
        echo 'logging';
    }
}
