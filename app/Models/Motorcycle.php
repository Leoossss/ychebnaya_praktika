<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand', 'model', 'year',
        'price', 'stock', 'description', 'image', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Аксессор для полного названия
    public function getFullNameAttribute()
    {
        return $this->brand . ' ' . $this->model;
    }

    // Скоуп для опубликованных
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}