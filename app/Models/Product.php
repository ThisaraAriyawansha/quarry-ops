<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'name_si', 'unit', 'unit_price', 'stock_quantity', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'stock_quantity' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
