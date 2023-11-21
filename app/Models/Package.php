<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
    public function pricing(){
      return $this->hasMany('App\Models\Pricing','package_id');
    }
}
