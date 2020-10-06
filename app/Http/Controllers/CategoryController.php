<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    function index() {
        Session::put('page', 'categories');
        return view('categories');
    }

    function getCategories() {
        $data = Category::orderBy('id', 'desc')->with('products')->get();
        return $data;
    }

    function deleteCategory($id) {
        $result = Category::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function addCategory(Request $request) {
        $name = $request->name;
        $created_by = Auth::user()->id;

        $result = Category::insert([
            'name' => $name,
            'created_by' => $created_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function getCategoryDetails($id) {
        return Category::find($id);
    }

    function updateCategoryDetails(Request $request) {
        $id = $request->id;
        $name = $request->name;
        $updated_by = Auth::user()->id;

        $result = Category::where('id', $id)->update([
            'name' => $name,
            'updated_by' => $updated_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }
}
