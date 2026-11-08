<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address'];

    // One supplier supplies many products (Product model comes later)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
}
