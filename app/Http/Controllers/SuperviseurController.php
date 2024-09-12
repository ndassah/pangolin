<?php

namespace App\Http\Controllers;

use App\Models\Superviseur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuperviseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupérer les utilisateurs ayant le role_id correspondant à "superviseur"
        $superviseurs = User::whereHas('role', function ($query) {
            $query->where('name', 'superviseur');
        })->get();

        return response()->json($superviseurs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $superviseur = Superviseur::create([
            'uuid'=> Str::uuid(),
            'user_id' => $validated['user_id'],
            'service_id' => $validated['service_id'],
        ]);

        return response()->json($superviseur->load('user', 'service'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $superviseur = Superviseur::with('user')->findOrFail($id);
        return response()->json($superviseur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $superviseur = Superviseur::findOrFail($id);

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $superviseur->update(array_filter([
            'service_id' => $validated['service_id'] ?? $superviseur->service_id,
        ]));

        return response()->json($superviseur->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $superviseur = Superviseur::findOrFail($id);
        $superviseur->delete();

        return response()->json(null, 204);
    }
}
