<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Client extends Authenticatable implements JWTSubject
{
    use HasApiTokens, Notifiable;

    protected $fillable = ['email', 'password', 'phone', 'fname', 'lname', 'image', 'area_id', 'city_id', 'pin_code', 'active'];

    protected $hidden = [
        'password',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function dialogs()
    {
        return $this->hasMany('App\Models\Dialog');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
