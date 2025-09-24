<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationAccepted extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'programme_id',
        'institute_id',
    ];

    /**
     * Get the application that owns the acceptance.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the programme that owns the acceptance.
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Get the institute that owns the acceptance.
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
