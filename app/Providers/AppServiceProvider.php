<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    public function boot(): void
    {
        //
    }
}