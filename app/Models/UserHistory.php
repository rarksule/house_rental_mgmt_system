<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = ['type','house_id','user_id','content'];
    
    public function house(){
        $this->belongsTo(House::class,'house_id');
    }
}
