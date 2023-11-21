<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Researchwork extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function service(){
        return $this->hasMany('App\Service','id','service_id');
      }
}
