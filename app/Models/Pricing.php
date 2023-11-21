<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $guarded = [];

     public function attribute(){
        return $this->belongsTo('App\Models\Attribute','attribute_id');
    }
}
