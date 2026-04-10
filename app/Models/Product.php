<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
     use SoftDeletes, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock_quantity',
        'low_stock_threshold',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function scopeFilter($query, $filter)
    {
        return $filter->apply($query);
    }

    public function scopeOrdering($query, $ordering = null)
{
    if (!$ordering) {
        return $query->orderBy('created_at', 'desc');
    }

    if ($ordering == 'oldest') {
        return $query->orderBy('created_at', 'asc');
    }

    return $query->orderBy('created_at', 'desc');
}
}
