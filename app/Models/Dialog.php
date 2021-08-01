<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{

    protected $fillable = ['subject', 'type', 'client_id'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message');
    }
}
