<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'firstnames',
        'surname',
        'gender',
        'phone',
        'address',
        'dob',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    /**
     * Get the user that owns the applicant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the applications for the applicant.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
