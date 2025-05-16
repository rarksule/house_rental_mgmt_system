<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\House;
use Spatie\MediaLibrary\HasMedia;
use App\HistoryTrait;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia, SoftDeletes, HistoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone_verified_at',
        'contact_number',
        'status',
        'role',
        'greetings',
        'address',
        'city',
        'house_number',
        'employment',
        'family_members',
        'kids',
        'nid_number',
        'locale',

    ];


    public function houses(): HasMany
    {
        return $this->hasMany(House::class, 'owner_id', 'id');
    }

    public function rentedHouse()
    {
        return $this->hasOne(House::class, 'tenant_id');
    }


    public function houseHistories()
    {
        return $this->hasManyThrough(
            UserHistory::class,
            House::class,
            'owner_id', // Foreign key on houses table
            'house_id', // Foreign key on histories table
            'id',       // Local key on users table
            'id'        // Local key on houses table
        );
    }

    // In User model
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function history()
    {
        return $this->hasMany(UserHistory::class, 'user_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
        'role' => 'integer',
    ];

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    public function addImage(): void
    {
        $this->clearMediaCollection('profile_image');
        $this->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                // If permanently deleting, force delete houses
                $user->sentMessages()->delete();
                $user->receivedMessages()->delete();
                if (isOwner($user)) {

                    $user->houses()->withTrashed()->forceDelete();
                } else if (isTenant($user)) {
                    $house = optional($user->rentedHouse())->withTrashed()->first();

                    if ($house) {
                        $house->update([
                            'tenant_id' => null,
                            'rented' => false,
                            'payment_date' => null,
                        ]);
                    }
                }
            } else {
                // If soft deleting, soft delete houses
                if (isOwner($user)) {
                    $user->houses()->delete();

                } else if (isTenant($user)) {
                    $house = optional($user->rentedHouse())->withTrashed()->first();

                    if ($house) {
                        $house->update([
                            'tenant_id' => null,
                            'rented' => false,
                            'payment_date' => null,
                        ]);
                        $this->recordHistory(RELEASED, $user, $house->id);
                    }


                }

            }
        });

        static::restoring(function ($user) {
            // Restore soft deleted houses when owner is restored
            if (isOwner($user) && $user->houses()->withTrashed()!=null) {
                $user->houses()->withTrashed()->restore();
            }
        });
    }
}
