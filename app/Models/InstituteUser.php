<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstituteUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'institute_id',
        'user_Id',
    ];

    /**
     * Get the institute that owns the institute user.
     */
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    /**
     * Get the user that owns the institute user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_Id');
    }
}
