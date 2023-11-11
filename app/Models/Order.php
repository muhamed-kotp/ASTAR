<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'total',
        'payment_method',
    ];

    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function orderDetails ()
    {
        return $this->hasMany('App\Models\OrderDetail');
    }

}