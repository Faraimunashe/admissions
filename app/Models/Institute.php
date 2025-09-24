<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'web',
        'logo',
    ];

    /**
     * Get the programmes for the institute.
     */
    public function programmes(): BelongsToMany
    {
        return $this->belongsToMany(Programme::class, 'institute_programmes')
                    ->withPivot('active')
                    ->withTimestamps();
    }

    /**
     * Get the users for the institute.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'institute_users')
                    ->withTimestamps();
    }

    /**
     * Get the institute programmes pivot records.
     */
    public function instituteProgrammes(): HasMany
    {
        return $this->hasMany(InstituteProgramme::class);
    }

    /**
     * Get the institute users pivot records.
     */
    public function instituteUsers(): HasMany
    {
        return $this->hasMany(InstituteUser::class);
    }

    /**
     * Get the application acceptances for this institute.
     */
    public function applicationAcceptances(): HasMany
    {
        return $this->hasMany(ApplicationAccepted::class);
    }

    /**
     * Get the application offers for this institute.
     */
    public function applicationOffers(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeOffered::class);
    }

    /**
     * Get the application rejections for this institute.
     */
    public function applicationRejections(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeRejected::class);
    }
}
