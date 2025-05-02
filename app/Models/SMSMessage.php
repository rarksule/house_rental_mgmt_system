<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSMessage extends Model
{
    protected $fillable = ['expires_at','code','phone'];
    protected $casts=[
        'expires_at'=> 'datetime',
    ];
}
