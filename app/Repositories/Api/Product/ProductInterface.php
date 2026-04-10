<?php

namespace App\Repositories\Api\Product;

interface ProductInterface
{
    // public function get();
    public function index($request, $filter);
    public function show($productId);

    public function store($request);

    public function update($request,$productId);

    public function destroy($productId);

    public function adjustStock($productId, $request);
    public function lowStock($request);
}
