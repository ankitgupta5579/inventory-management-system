<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = ['name', 'description'];

    // One category has many products (Product model comes later)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
