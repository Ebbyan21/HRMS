<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance_review_id',
        'kpi_id',
        'rating',
        'comments',
    ];

    public function performanceReview(): BelongsTo
    {
        return $this->belongsTo(PerformanceReview::class);
    }

    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }
}