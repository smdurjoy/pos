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
        $this->validate($request, [
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'pass' => 'required',
        ]);

        $role = $request->input('role');
        $name = $request->input('name');
        $email = $request->input('email');
        $pass = bcrypt($request->input('pass'));
        $status = 1;

        $result = User::insert([
            'role' => $role,
            'name' => $name,
            'email' => $email,
            'password' => $pass,
            'status' => $status,
        ]);

        if($result == true) {
            return 1;
        } else {
            return 0;
        }
    }

    function deleteUser($id) {
        $user = User::find($id);
        $imagePath = "images/userImages/";

        if(file_exists("images/userImages/".$user->image) AND !empty($user->image)) {
            unlink($imagePath.$user->image);
        }

        $result = $user->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function getUserEditDetails($id) {
        $result = User::find($id);
        return $result;
    }

    function updateUserDetails(Request $request) {
        $id = $request->input('id');
        $role = $request->input('role');
        $name = $request->input('name');
        $email = $request->input('email');

        $result = User::where('id', $id)->update([
            'role' => $role,
            'name' => $name,
            'email' => $email,
        ]);

        if($result == true) {
            return 1;
        } else {
            return 0;
        }
    }
}
