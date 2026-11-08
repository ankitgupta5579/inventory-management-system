<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['user_id', 'customer_name', 'sale_date', 'total'];

    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'total'     => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
