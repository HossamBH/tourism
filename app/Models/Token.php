<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = ['token', 'customer_id', 'platform'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
