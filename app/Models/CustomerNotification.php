<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Config;
class CustomerNotification extends Model
{
    use HasFactory;
     public function getCreatedAtAttribute($value){
        $perseData =  Carbon::parse($value)->timezone(Config::get('app.timezone'))->format('Y-m-d H:i:s');
         $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $perseData)->diffForHumans();
          return str_replace(['0','1','2','3','4','5','6','7','8','9',' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', 'ago'], ['0','1','2','3','4','5','6','7','8','9',' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', 'ago'], $created_at);

    }
}
