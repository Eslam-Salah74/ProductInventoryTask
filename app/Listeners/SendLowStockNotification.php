<?php

namespace App\Listeners;

use App\Events\LowStockAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendLowStockNotification
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
    public function handle(LowStockAlert $event): void
    {
        $product = $event->product;

        
        Log::warning('LOW STOCK ALERT', [
            'product_id' => $product->id,
            'name' => $product->name,
            'stock' => $product->stock_quantity,
            'threshold' => $product->low_stock_threshold,
        ]);
    }
}
