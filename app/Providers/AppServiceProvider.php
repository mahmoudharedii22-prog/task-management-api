<?php

namespace App\Providers;

use App\Contracts\CommentRepoInterface;
use App\Contracts\TaskRepoInterface;
use App\Contracts\UserRepoInterface;
use App\Repositories\CommentRepoImplementation;
use App\Repositories\TaskRepoImplementation;
use App\Repositories\UserRepoImplementation;
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

        $this->app->bind(
            UserRepoInterface::class,
            UserRepoImplementation::class
        );

        $this->app->bind(
            CommentRepoInterface::class,
            CommentRepoImplementation::class
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
