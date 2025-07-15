<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LeaveRequestPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * Admin bisa melakukan apa saja.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Admin')) {
            return true;
        }
 
        return null;
    }

    /**
     * Determine whether the user can view any models.
     * Manajer & Admin bisa liat list cuti.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can view the model.
     * Manajer & Admin bisa liat detail.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
         return $user->hasRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can create models.
     * Pengajuan cuti dibuat dari halaman karyawan, bukan dari panel admin.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     * Manajer & Admin bisa update (approve/reject).
     */
    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasRole(['Admin', 'Manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasRole('Admin');
    }
}