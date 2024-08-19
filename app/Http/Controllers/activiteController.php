<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;

class activiteController extends Controller
{
    //afficher toutes les activites
    public function index(){
        $acticitesAll = Activite::all();
    }

    //creation d'une activite
    public function create(Request $request){

        $request->validate([
            'nom_activites'=>'required|string|max:250',
            'id_service'=>'required|numeric',
            'description' => 'required|text',
        ]);

        Activite::create([
            'nom_activites'=>$request->nom_activites,
            'id_service'=>$request->id_service,
            'description'=>$request->description,
        ]);

        return response([
            'message' => 'activites crees avec success',
        ], 201);
    }


    //afficher une activite par son id
    public function show($id){
        return Activite::find($id);
    }

    //mise a jour d'une activite
    public function update(Request $request, $id){

    }
}
