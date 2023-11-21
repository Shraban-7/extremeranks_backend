<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id')->select('id','fullName','image');
    }

    public function orderdetail(){
        return $this->belongsTo('App\Models\orderDetails', 'id',  'order_id');
    }
    
    public function orderdetails(){
      return $this->hasMany('App\Models\orderDetails','order_id');
    }

    public function ordertype(){
        return $this->belongsTo('App\Models\Ordertype','order_status');
    }

    public function payment(){
        return $this->hasOne('App\Models\Payment','order_id');
    }
    public function review(){
        return $this->hasOne('App\Models\Review','order_id');
    }
    
    public function deliveryfile(){
        return $this->hasOne('App\Models\Deliveryfile','order_id')->latest();
    }
    public function attributes(){
      return $this->hasMany('App\Models\OrderAttribute','order_id');
    }
    public function unreadmessages(){
        return $this->hasMany(Message::class,'order_id')->where(['status'=>'unread','sender'=>'admin'])->whereNotNull('order_id')->select('id','order_id','status','sender');
    }


}
