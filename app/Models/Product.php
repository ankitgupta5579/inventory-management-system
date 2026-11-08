<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'sku', 'description',
        'category_id', 'supplier_id',
        'purchase_price', 'selling_price',
        'quantity', 'reorder_level',
    ];

    // A product belongs to one category and (optionally) one supplier
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Reusable filter: Product::lowStock()->get()
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'reorder_level');
    }
}
