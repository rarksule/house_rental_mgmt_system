<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReplay extends Model
{
    protected $fillable = ['user_id','review_id','content'];
    

    public function Review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
