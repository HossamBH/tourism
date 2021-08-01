<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{


    protected $fillable = ['name_en', 'description_en', 'name_ar', 'description_ar', 'main_image', 'images', 'address_ar', 'address_en', 'area_id', 'city_id', 'category_id', 'longitude', 'latitude', 'rating', 'counter', 'active_topRating', 'active_popular'];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function hotel()
    {
        return $this->hasMany('App\Models\Hotel');
    }

   
}
