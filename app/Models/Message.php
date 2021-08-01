<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = ['body', 'sender', 'dialog_id', 'check_image', 'check_read', 'user_id'];

    public function dialog()
    {
        return $this->belongsTo('App\Models\Dialog');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
