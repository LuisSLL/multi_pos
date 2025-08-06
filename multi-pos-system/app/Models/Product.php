<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'code',
        'description',
        'cost_price',
        'selling_price',
        'stock_quantity',
        'min_stock_level',
        'image',
        'is_active'
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock_level;
    }

    public function getMarginAttribute()
    {
        return $this->selling_price - $this->cost_price;
    }

    public function getMarginPercentageAttribute()
    {
        return $this->cost_price > 0 ? (($this->selling_price - $this->cost_price) / $this->cost_price) * 100 : 0;
    }
}
