<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable,HasRoles,SoftDeletes,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'phone_number',
        'terms_accepted'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'fullName' => Attribute::make(
            //     get: fn ($value,$attributes) => $attributes['first-name'].$attributes['last-name'],
            // ),
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected function fullName() : Attribute{
        return Attribute::make(
            get: fn ($value,$attributes) => $attributes['first_name'].' '.$attributes['last_name'],
            
        );
    }

    // public function getFullNameAttribute() {
    //     return $this['first-name'].$this['last-name'];
    // }

    


    public function projects() : HasMany {
        return $this->hasMany(Project::class,'assigned_user');
    }

    public function tasks() : HasMany{
        return $this->hasMany(Task::class,'user_id');
    }
}
