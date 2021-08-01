<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

    protected $fillable = ['image', 'title_en', 'description_en','title_ar', 'description_ar'];
}
