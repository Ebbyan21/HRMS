<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'description',
        'requirements',
        'status',
        'deadline',
    ];

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}