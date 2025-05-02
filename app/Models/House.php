<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use App\Models\User;
use Spatie\MediaLibrary\InteractsWithMedia;

class House extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'owner_id',
        'tenant_id',
        'price',
        'description',
        'payment_date',
        'address',
        'rooms',
        'privateNotes',
        'latitude',
        'longitude',
        'area',
        'amenities',
        'rented',
    ];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'house_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    public function getImage()
    {
        if ($this->getMedia() != null) {
            $media = $this->getMedia('images');
            $imageUrls = [];
            foreach ($media as $image) {
                array_push($imageUrls, $image->getUrl());
            }
            return $imageUrls;
        }
        return [];
    }

   

    public function setAmenitiesAttribute($value): void
    {
        $this->attributes['amenities'] = json_encode($value);
    }

    public function getAmenitiesAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }


}
