<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable =[
        'title','description','price','quantity','partition_id','img'
    ];

    public function partition ()
    {
        return $this->belongsTo('App\Models\Partition');
    }

}
