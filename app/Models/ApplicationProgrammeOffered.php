<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationProgrammeOffered extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_id',
        'institute_id',
        'user_id',
        'offer_details',
    ];

    /**
     * Get the application that owns the offer.
     * This represents when an officer makes an offer to a student.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the programme that is being offered.
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Get the institute making the offer.
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * Get the officer who made the offer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
