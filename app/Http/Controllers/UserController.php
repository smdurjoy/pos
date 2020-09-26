<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;

class UserController extends Controller
{
    function users() {
        Session::put('page', 'users');
        $users = User::all();
        return view('users')->with(compact('users'));
    }

    function addEditUsers(Request $request, $id=null) {
        if($id == '') {
            $user = new User;
            $title = 'Add User';
            $message = 'User Added Successfully !';
        }
        else {
            $user = User::find($id);
            $title = 'Edit User';   
            $message = 'User Updated Successfully !';
        }
        return view('addEditUser')->with(compact('title', 'user'));
    }
}
