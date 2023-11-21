<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $casts = [
       'created_at' => 'datetime:Y-m-d H:i A',
    ];
     public function user(){
        return $this->belongsTo(User::class,'admin_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
