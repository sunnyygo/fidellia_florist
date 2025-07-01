<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    'name',
    'phone',
    'email',
    'product_id',
    'flower_id',
    'flower_color_id',
    'background_color_id',
    'list_color_id',
    'address',
    'total_price',
    'image_url',
    'status_order',
    'kalimat',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function flower() {
        return $this->belongsTo(Flower::class);
    }

    public function flowerColor() {
        return $this->belongsTo(Color::class, 'flower_color_id');
    }

    public function backgroundColor() {
        return $this->belongsTo(Color::class, 'background_color_id');
    }

    public function listColor() {
        return $this->belongsTo(Color::class, 'list_color_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
