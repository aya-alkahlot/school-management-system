<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Repository\TeacherRepositoryInterface',
            'App\Repository\TeacherRepository'
        );

        $this->app->bind(
            'App\Repository\StudentRepositoryInterface',
            'App\Repository\StudentRepository'
        );
        $this->app->bind(
            'App\Repository\StudentPromotionRepositoryInterface',
            'App\Repository\StudentPromotionRepository'
        );
        $this->app->bind(
            'App\Repository\StudentGraduatedRepositoryInterface',
            'App\Repository\StudentGraduatedRepository'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
