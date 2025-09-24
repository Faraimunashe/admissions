<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstituteProgramme extends Model
{
    use HasFactory;

    protected $fillable = [
        'institute_id',
        'programme_id',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    /**
     * Get the institute that owns the institute programme.
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * Get the programme that owns the institute programme.
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    /**
     * Scope a query to only include active programmes.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
