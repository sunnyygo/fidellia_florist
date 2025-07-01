<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name','hex_code'];

    public function flowerVariants() {
        return $this->hasMany(FlowerVariant::class);
    }
}
