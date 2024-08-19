<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use Illuminate\Http\Request;

class directionController extends Controller
{
    public function index(){
        return Direction::all();
    }
    public function create(Request $request){

        $direction = $request->validate([
            'nom_direction' => 'required|string|max:100'
        ]);

       Direction::create($direction);

       return response([
        'message' => 'Direction cree avec success',
        'direction' => $direction
    ], 201);

    }

    public function show($id){
        return Direction::find($id);
    }
}
