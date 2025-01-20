<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'booking_id', 'name', 'qty', 'price', 'options'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

