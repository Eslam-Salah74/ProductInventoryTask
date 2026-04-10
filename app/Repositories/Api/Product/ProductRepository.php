<?php

namespace App\Repositories\Api\Product;



class ProductRepository implements ProductInterface
{
    public function get()
    {
        return response()->json([
            'products' => "TEST",
        ]);
    }
}
