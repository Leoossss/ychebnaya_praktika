<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'motorcycle_id', 'quantity', 'price'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}