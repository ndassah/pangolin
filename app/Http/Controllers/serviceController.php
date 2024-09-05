<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('direction', /*'stagiaires'*/)->get();
        return response()->json($services);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_services' => 'required|string|max:255',
            'id_direction' => 'required|exists:directions,id',
            'description' => 'required |string'
        ]);

        $service = Service::create($validated);

        return response()->json($service->load('direction'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::with('direction', 'stagiaires')->findOrFail($id);
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'nom_services' => 'sometimes|string|max:255',
            'id_direction' => 'sometimes|exists:directions,id',
            'description' => 'string',
        ]);

        $service->update(array_filter($validated));

        return response()->json($service->load('direction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(null, 204);
    }
}
