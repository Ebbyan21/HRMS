<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <--- TAMBAHKAN INI

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'department',
        'hire_date',
        'phone_number',
        'address',
        'reports_to', // <--- TAMBAHKAN INI
    ];
    
    // --- TAMBAHKAN BLOK DI BAWAH INI ---
    /**
     * Get the user for the employee record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the manager for the employee.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reports_to');
    }
    // ------------------------------------
}