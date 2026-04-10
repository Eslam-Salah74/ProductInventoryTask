<?php

namespace App\Filters\Api;

use App\Filters\Filters;

class ProductFilter extends Filters
{
    protected $var_filters = [
        'name',
        'sku',
        'status',
    ];

    public function name($value)
    {
        return $this->builder->where('name', 'LIKE', "%$value%");
    }

    public function sku($value)
    {
        return $this->builder->where('sku', 'LIKE', "%$value%");
    }

    public function status($value)
    {
        return $this->builder->where('status', $value);
    }

}
