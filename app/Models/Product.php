<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description'];
    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
