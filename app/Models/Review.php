<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'house_id',
        'tenant_id',
        'rating',
        'comment',
        'had_visit',
    ];

    
    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function replies()
    {
        return $this->hasMany(ReviewReplay::class, 'review_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
    ];


    public function getImageAttribute(): string
    {
        if ($this->getMedia() != null) {
            return $this->getFirstMediaUrl();
        }
        return asset('assets/images/no-image.jpg');
    }

    public function addImageAttribute(): void
    {
        $this->addMediaFromRequest('image')->toMediaCollection('profile_image');
    }
}
