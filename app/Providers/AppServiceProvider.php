<?php

namespace App\Providers;

use App\Contracts\TaskRepoInterface;
use App\Repositories\TaskRepoImplementation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TaskRepoInterface::class,
            TaskRepoImplementation::class
        );
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
