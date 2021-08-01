<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $casts = ['images' => 'array'];

    protected $fillable = ['name_en', 'description_en', 'name_ar', 'description_ar', 'main_client', 'images', 'address_en', 'address_ar', 'rating', 'counter', 'area_id', 'city_id', 'place_id'];


    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }

    public function getImagesAttribute($value)
    {

        $images = explode(',', $value);

        return $images;
    }
}
