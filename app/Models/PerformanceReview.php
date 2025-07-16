<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerformanceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_user_id',
        'reviewer_user_id',
        'review_date',
        'overall_comments',
        'status',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReviewItem::class);
    }
}