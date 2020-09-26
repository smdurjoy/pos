<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;

class UserController extends Controller
{
    function users() {
        Session::put('page', 'users');
        return view('users');
    }

    function getUserData() {
        return User::orderBy('id', 'desc')->get();
    }

    function addUser(Request $request) {
        $role = $request->input('role');
        $name = $request->input('name');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $confPass = $request->input('confPass');

        $result = User::insert([
            'role' => $role,
            'name' => $name,
            'email' => $email,
            'password' => $pass,
        ]);

        if($result == true) {
            return 1;
        } else {
            return 0;
        }
    }
}
