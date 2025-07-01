<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundColor extends Model
{
    protected $fillable = [
        'id'
    ];
    protected $table = 'background_color';
    public function color(){
        return $this->belongsTo(Color::class);
    }
}
