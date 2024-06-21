<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'subscriptions' => Subscription::all(),
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
    public function store(SubscriptionRequest $request): JsonResponse
    {
        $days = Plan::find($request->plan_id)->duration;
        $subscription = Subscription::create([
            'member_id' => $request->member_id,
            'plan_id' => $request->plan_id,
            'start_date' => $request->start_date,
            'end_date' => Carbon::parse($request->start_date)
                            ->addDays($days)
                            ->format('Y-m-d'),
        ]);
        $subscription->save();

        return response()->json([
            'subscription' => $subscription,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'subscription' => Subscription::findOrFail($id),
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
    public function update(SubscriptionRequest $request, string $id): JsonResponse
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update($request->all());

        return response()->json([
            'subscription' => $subscription,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json(null, 204);
    }
}
