<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partition extends Model
{
    protected $fillable =[
        'title','img','category_id'
    ];

    public function category ()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function items ()
    {
        return $this->hasMany('App\Models\Item');
    }
}