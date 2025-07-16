<?php

namespace App\Providers;

use App\Models\Claim;
use App\Models\LeaveRequest;
use App\Policies\ClaimPolicy;
use App\Policies\LeaveRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan semua Policy di sini
        Gate::policy(LeaveRequest::class, LeaveRequestPolicy::class);
        Gate::policy(Claim::class, ClaimPolicy::class);
    }
}