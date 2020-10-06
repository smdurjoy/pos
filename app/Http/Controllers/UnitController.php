<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Unit;
use Auth;

class UnitController extends Controller
{
    function index() {
        Session::put('page', 'units');
        return view('units');
    }

    function getUnits() {
        $data = Unit::orderBy('id', 'desc')->with('products')->get();
        return $data;
    }

    function deleteUnit($id) {
        $result = Unit::find($id)->delete();

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function addUnit(Request $request) {
        $name = $request->name;
        $created_by = Auth::user()->id;

        $result = Unit::insert([
            'name' => $name,
            'created_by' => $created_by,
        ]);

        if($result == true) {
            return 1;
        } else { 
            return 0;
        }
    }

    function getUnitDetails($id) {
        return Unit::find($id);
    }

    function updateUnitDetails(Request $request) {
        $id = $request->id;
        $name = $request->name;
        $updated_by = Auth::user()->id;

        $result = Unit::where('id', $id)->update([
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
