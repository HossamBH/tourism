<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name_en','name_ar'];

    public function places()
    {
        return $this->hasMany('App\Models\Place');
    }
}
