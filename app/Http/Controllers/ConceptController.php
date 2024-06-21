<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConceptRequest;
use App\Models\Concept;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'concepts' => Concept::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConceptRequest $request): JsonResponse
    {
        $concept = Concept::create($request->all());
        $concept->save();

        return response()->json([
            'concept' => $concept,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'concept' => Concept::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConceptRequest $request, string $id): JsonResponse
    {
        $concept = Concept::findOrFail($id);
        $concept->update($request->all());

        return response()->json([
            'concept' => $concept,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $concept = Concept::findOrFail($id);
        $concept->delete();

        return response()->json(null, 204);
    }
}
