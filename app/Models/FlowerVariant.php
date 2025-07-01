<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlowerVariant extends Model
{
    use HasFactory;

    protected $fillable = ['flower_id', 'color_id', 'stock'];

    public function flower() {
        return $this->belongsTo(Flower::class);
    }

    public function color() {
        return $this->belongsTo(Color::class);
    }
}
