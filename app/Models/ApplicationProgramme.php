<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationProgramme extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_id',
        'choice',
    ];

    /**
     * Get the application that owns the application programme.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the programme that owns the application programme.
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Scope a query to order by choice priority.
     */
    public function scopeByChoice($query)
    {
        return $query->orderBy('choice');
    }
}
