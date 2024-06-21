<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'plans' => Plan::all(),
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
    public function store(PlanRequest $request): JsonResponse
    {
        $plan = Plan::create($request->all());
        $plan->save();

        return response()->json([
            'plan' => $plan,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'plan' => Plan::findOrFail($id),
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
    public function update(PlanRequest $request, string $id): JsonResponse
    {
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());

        return response()->json([
            'plan' => $plan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return response()->json(null, 204);
    }
}
