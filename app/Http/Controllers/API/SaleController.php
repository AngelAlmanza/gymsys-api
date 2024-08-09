<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Events\SaleCreated;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'sales' => Sale::all(),
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
    public function store(SaleRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $total = 0;

            foreach ($request->concepts as $concept) {
                $product = Product::findOrFail($concept['product_id']);

                if ($product->stock < $concept['quantity']) {
                    return response()->json([
                        'message' => 'The product ' . $product->name . ' does not have enough stock',
                    ], 400);
                }

                $quantity = (string) $concept['quantity'];
                $price = (string) $product->price;
                $subtotal = bcmul($quantity, $price, 2);

                $total = bcadd($total, $subtotal, 2);
                $product->stock -= $concept['quantity'];
                $product->save();
            }

            $sale = Sale::create([
                'member_id' => $request->member_id,
                'invoice_number' => "GYM" . date("YmdHis") . rand(1000, 9999) . $request->member_id,
                'date' => $request->date,
                'total' => $total,
            ]);
            $sale->save();

            SaleCreated::dispatch($request->concepts, $sale->id);

            DB::commit();

            return response()->json([
                'sale' => $sale,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred while trying to create the sale',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json([
            'sale' => Sale::findOrFail($id),
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
    public function update(SaleRequest $request, string $id): JsonResponse
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());

        return response()->json([
            'sale' => $sale,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return response()->json(null, 204);
    }
}
