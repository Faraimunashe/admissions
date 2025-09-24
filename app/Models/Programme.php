<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the institutes that offer this programme.
     */
    public function institutes(): BelongsToMany
    {
        return $this->belongsToMany(Institute::class, 'institute_programmes')
                    ->withPivot('active')
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
     * Get the application programmes for this programme.
     */
    public function applicationProgrammes(): HasMany
    {
        return $this->hasMany(ApplicationProgramme::class);
    }

    /**
     * Get the application acceptances for this programme.
     */
    public function applicationAcceptances(): HasMany
    {
        return $this->hasMany(ApplicationAccepted::class);
    }

    /**
     * Get the application offers for this programme.
     */
    public function applicationOffers(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeOffered::class);
    }

    /**
     * Get the application rejections for this programme.
     */
    public function applicationRejections(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeRejected::class);
    }
}
