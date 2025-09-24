<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the applicant profile for the user.
     */
    public function applicant(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Get the institutes for the user.
     */
    public function institutes(): BelongsToMany
    {
        return $this->belongsToMany(Institute::class, 'institute_users')
                    ->withTimestamps();
    }

    /**
     * Get the institute users pivot records.
     */
    public function instituteUsers(): HasMany
    {
        return $this->hasMany(InstituteUser::class, 'user_Id');
    }

    /**
     * Get the application offers made by this user.
     */
    public function applicationOffers(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeOffered::class);
    }

    /**
     * Get the application rejections made by this user.
     */
    public function applicationRejections(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeRejected::class);
    }
}
