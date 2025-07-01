<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone', 'email',
        'midtrans_order_id', 'total_amount', 'status','midtrans_order_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

