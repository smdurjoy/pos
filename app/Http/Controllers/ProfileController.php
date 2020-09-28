<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;

class ProfileController extends Controller
{
    function userProfile() {
        Session::put('page', 'profile');
        return view('profile');
    }

    function getProfileData() {
        $id = Auth::user()->id;
        $user = User::find($id);

        if($user->image == null) {
            $user->image = "smallDummyImg.png";
        }

        return $user;
    }

    function getProfileEditDetails() {
        $id = Auth::user()->id;
        $user = User::find($id);

        if($user->image == null) {
            $user->image = "smallDummyImg.png";
        }

        return $user;
    }

    function updateProfileInfo(Request $request) {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->mobile = $request->mobile;
        $user->gender = $request->gender;
        $imagePath = "images/userImages/";
        
        if($request->hasFile('image')) {
            $imageTmp = $request->file('image');
            if($imageTmp->isValid()) {
                $originalName = $imageTmp->getClientOriginalName();
                $imageName = date('YmdHi').chr(rand(65,90)).'-'.$originalName;
                if(file_exists($imagePath.$user->image)) {
                    unlink($imagePath.$user->image);
                }
                $imageTmp->move(public_path($imagePath), $imageName);
                $user->image = $imageName;
            }
        }

        $result = $user->save();

        if($result == true) {
            return 1;
        } else {
            return 0;
        }
    }
}       
