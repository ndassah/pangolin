<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Direction;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    public function index(){
        return Service::all();
    }

    public function create(Request $request){
        $service = $request->validate([
            'nom_services' => 'required|string|max:100',
            'id_direction'=>'required|numeric',
        ]);

        Service::create($service);

        return response([
            'message' => 'Service cree avec success',
        ], 201);

    }
    public function show($id){
        return Service::find($id);
    }
}
