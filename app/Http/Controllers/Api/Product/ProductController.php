<?php

namespace App\Http\Controllers\Api\Product;

use App\Filters\Api\ProductFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Api\Product\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
    // public function get()
    // {
    //     $products = $this->product->get();
    //     return $products;
    // }

    public function index(Request $request, ProductFilter $filter)
    {
        return $this->product->index($request, $filter);
    }

    public function show($productId)
    {
        return $this->product->show($productId);
    }

    public function store(StoreProductRequest $request)
    {
        return $this->product->store($request);
    }

    public function update($productId, UpdateProductRequest $request)
    {
        return $this->product->update($productId, $request);
    }

    public function destroy($productId)
    {
        return $this->product->destroy($productId);
    }

    public function adjustStock($productId, Request $request)
    {
        return $this->product->adjustStock($productId, $request);
    }

    public function lowStock(Request $request)
    {
        return $this->product->lowStock($request);
    }


}
