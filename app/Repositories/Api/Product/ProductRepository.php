<?php

namespace App\Repositories\Api\Product;

use App\Events\LowStockAlert;
use App\Models\Product;
use App\Resources\Product\ProductResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;



class ProductRepository implements ProductInterface
{
    use ApiResponseTrait;

    public function getModel()
    {
        return new Product();
    }

    // public function get()
    // {
    //     return response()->json([
    //         'products' => "TEST",
    //     ]);
    // }



    public function index($request, $filter): \Illuminate\Http\JsonResponse
    {
        $perPage = $request['per_page'] ?? config('pagination.per_page');

        $cacheKey = 'products_index_' . md5(json_encode($request->all()));

        $result = Cache::tags(['products'])->remember($cacheKey, 3600, function () use ($request, $filter, $perPage) {

            $collection = $this->getModel()
                ->ordering($request->ordering)
                ->filter($filter);

            $data = $perPage == -1
                ? $collection->get()
                : $collection->paginate($perPage);

            return [
                'data' => $data,
                'paginated' => $perPage != -1
            ];
        });

        $data = $result['data'];
        $paginated = $result['paginated'];

        return $this->isOk(__('Product'))
            ->setData(
                $paginated
                    ? $this->api_model_set_paginate(ProductResource::collection($data), $data)
                    : ProductResource::collection($data)
            )
            ->build();
    }

    public function store($request)
    {
        try {
            $product = $this->getModel()->create($request->validated());

            Cache::tags(['products'])->flush();

            return $this->isOk(__('Stored Successfully'))
                ->setData(ProductResource::make($product))
                ->build();
        } catch (\Exception $e) {
            return $this->isError('An Error occured')
                ->setStatus(500)
                ->build();
        }
    }



    public function show($productId)
    {
        $cacheKey = 'product_show_' . $productId;

        $product = Cache::tags(['products'])->remember($cacheKey, 3600, function () use ($productId) {
            return $this->getModel()->find($productId);
        });

        if (!$product) {
            return $this->isError(__('Product Not Found'))
                ->setStatus(404)
                ->build();
        }

        return $this->isOk(__('Product Data'))
            ->setData(ProductResource::make($product))
            ->build();
    }



    public function update($productId, $request)
    {
        try {
            $product = $this->getModel()->find($productId);

            if (!$product) {
                return $this->isError(__('Product Not Found'))
                    ->setStatus(404)
                    ->build();
            }

            $product->update($request->validated());

            Cache::tags(['products'])->flush();
            if ($product->stock_quantity <= $product->low_stock_threshold) {
                event(new LowStockAlert($product));
            }
            return $this->isOk(__('Updated Successfully'))
                ->setData(ProductResource::make($product))
                ->build();
        } catch (\Exception $e) {
            return $this->isError('An Error occured')
                ->setStatus(500)
                ->build();
        }
    }

    public function destroy($productId)
    {
        $product = $this->getModel()->find($productId);

        if (!$product) {
            return $this->isError(__('Product Not Found'))
                ->setStatus(404)
                ->build();
        }

        $product->delete();

        Cache::tags(['products'])->flush();

        return $this->isOk(__('Destroyed Successfully'))
            ->build();
    }

    public function adjustStock($productId, $request)
    {
        $product = $this->getModel()->find($productId);

        if (!$product) {
            return $this->isError(__('Product Not Found'))
                ->setStatus(404)
                ->build();
        }

        $quantity = (int) $request->quantity;
        $type = $request->type;

        if ($quantity <= 0) {
            return $this->isError('Quantity must be greater than 0')
                ->setStatus(422)
                ->build();
        }

        if ($type === 'increment') {
            $product->stock_quantity += $quantity;
        } elseif ($type === 'decrement') {

            if ($product->stock_quantity < $quantity) {
                return $this->isError('Not enough stock')
                    ->setStatus(422)
                    ->build();
            }

            $product->stock_quantity -= $quantity;
        } else {
            return $this->isError('Invalid type')
                ->setStatus(422)
                ->build();
        }

        $product->save();

        Cache::tags(['products'])->flush();
        if ($product->stock_quantity <= $product->low_stock_threshold) {
            event(new LowStockAlert($product));
        }
        return $this->isOk(__('Stock Adjusted Successfully'))
            ->setData(ProductResource::make($product))
            ->build();
    }

    public function lowStock($request)
    {
        $threshold = $request->low_stock_threshold ?? 10;
        $products = $this->getModel()->where('stock_quantity', '<=', $threshold)->get();

        return $this->isOk(__('Low Stock Products'))
            ->setData(ProductResource::collection($products))
            ->build();
    }
}
