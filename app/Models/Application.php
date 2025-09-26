<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'period_id',
        'status',
    ];

    /**
     * Get the applicant that owns the application.
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Get the period that owns the application.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Get the programmes for the application.
     */
    public function programmes(): HasMany
    {
        return $this->hasMany(ApplicationProgramme::class);
    }

    /**
     * Get the documents for the application.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Get the acceptances for the application.
     */
    public function acceptances(): HasMany
    {
        return $this->hasMany(ApplicationAccepted::class);
    }

    /**
     * Get the first acceptance for the application (for backward compatibility).
     */
    public function acceptance(): HasOne
    {
        return $this->hasOne(ApplicationAccepted::class);
    }

    /**
     * Get the offers for the application.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeOffered::class);
    }

    /**
     * Get the rejections for the application.
     */
    public function rejections(): HasMany
    {
        return $this->hasMany(ApplicationProgrammeRejected::class);
    }

    /**
     * Scope a query to only include pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope a query to only include responded applications.
     */
    public function scopeResponded($query)
    {
        return $query->where('status', 'RESPONDED');
    }

    /**
     * Check if the application has been accepted by the student.
     */
    public function isAccepted(): bool
    {
        return $this->acceptances()->exists();
    }

    /**
     * Get the accepted offer (if any).
     */
    public function acceptedOffer()
    {
        return $this->acceptances()->first();
    }
}
