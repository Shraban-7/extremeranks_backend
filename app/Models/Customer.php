<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'fullName', 'phoneNumber','email','address','password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function unreadmessages(){
        return $this->hasMany(Message::class)->where(['status'=>'unread','sender'=>'customer','order_id'=>NULL]);
    }

    
}
