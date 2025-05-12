<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = ['type','house_id','user_id','content'];
    
    public function house()
    {
        return $this->belongsTo(House::class);
    }

    // Relationship with user who created the history
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
