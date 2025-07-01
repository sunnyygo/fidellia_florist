<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListColor extends Model
{
    protected $fillable = [
        'id'
    ];
    protected $table = 'list_color';
    public function color(){
        return $this->belongsTo(Color::class);
    }
}
