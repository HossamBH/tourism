<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = ['name_en','name_ar'];

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

    public function areas()
    {
        return $this->hasMany('App\Models\Area');
    }
}
