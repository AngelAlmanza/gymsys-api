<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Http\JsonResponse;

class MemberController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'members' => Member::all(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(MemberRequest $request)
    {
        $member = Member::create($request->all());
        $member->save();

        return response()->json([
            'member' => $member,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'member' => Member::findOrFail($id),
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(MemberRequest $request, string $id): JsonResponse
    {
        $member = Member::findOrFail($id);
        $member->update($request->all());

        return response()->json([
            'member' => $member,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(null, 204);
    }
}
