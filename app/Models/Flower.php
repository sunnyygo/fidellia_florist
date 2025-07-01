<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function variants() {
        return $this->hasMany(FlowerVariant::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
