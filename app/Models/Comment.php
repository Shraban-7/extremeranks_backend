<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at'  => 'date:M d, Y H:i:s',
    ];
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }
    
    public function blog(){
        return $this->hasOne('App\Models\Blog','id','blog_id');
    }
}
