<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'email',
        'description',
        'is_active',
        'payment_due_date',
        'monthly_fee',
        'payment_status'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'payment_due_date' => 'datetime',
        'monthly_fee' => 'decimal:2'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class)->where('user_type', 'store_owner');
    }

    public function employees()
    {
        return $this->hasMany(User::class)->where('user_type', 'employee');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function isPaymentOverdue()
    {
        return $this->payment_due_date && $this->payment_due_date->isPast() && $this->payment_status !== 'active';
    }
}
