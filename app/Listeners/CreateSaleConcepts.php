<?php

namespace App\Listeners;

use App\Events\SaleCreated;
use App\Models\Concept;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSaleConcepts
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaleCreated $event): void
    {
        foreach ($event->concepts as $concept) {
            $productPrice = Product::find($concept['product_id'])->price;

            Concept::create([
                'quantity' => $concept['quantity'],
                'product_id' => $concept['product_id'],
                'sale_id' => $event->saleId,
                'price' => $productPrice * $concept['quantity'],
            ])->save();
        }
    }
}
