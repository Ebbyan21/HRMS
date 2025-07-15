<?php

namespace App\Providers;

use App\Models\LeaveRequest;
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
        // Daftarkan Policy di sini
        Gate::policy(LeaveRequest::class, LeaveRequestPolicy::class);
    }
}