<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function package(){
        return $this->hasOne('App\Models\Package','id','package_id');
    }

    public function pricing(){
      return $this->hasMany('App\Models\Pricing','package_id');
    }

}
