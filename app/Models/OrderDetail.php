<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'price_each',
        'order_quantity',
    ];




    public function order ()
    {
        return $this->belongsTo('App\Models\Order');
    }
}