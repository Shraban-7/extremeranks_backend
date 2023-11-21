<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function pricing(){
        return $this->hasMany('App\Models\Pricing','attribute_id','id')->where('status',1);
    }
}
