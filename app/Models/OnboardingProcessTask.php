<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingProcessTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'onboarding_process_id',
        'title',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(OnboardingProcess::class, 'onboarding_process_id');
    }
}