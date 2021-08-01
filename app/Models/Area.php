<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $fillable = ['name_en','name_ar','city_id'];

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function places()
    {
        return $this->hasMany('App\Models\Place');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function hotels()
    {
        return $this->hasMany('App\Models\Hotel');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
