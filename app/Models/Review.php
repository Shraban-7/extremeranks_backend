<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','customer_id')->select('id','fullName');
    }
    
    public function order(){
        return $this->hasOne('App\Models\Order','id','order_id')->select('id','package_name');
    }
}
