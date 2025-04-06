<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_first_name',
        'user_last_name',
        'user_email',
        'user_password',
        'user_contact_no',
        'user_date_of_birth',
        'user_profile_image',
        'user_type',
        'user_account_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_password' => 'hashed',
    ];

    // Relationships
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'address_user_id');
    }

    public function employees(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
