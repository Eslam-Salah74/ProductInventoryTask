<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Repositories\Api\Product\ProductInterface;

class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    public function get()
    {
        $products = $this->product->get();
        return $products;
    }


}
