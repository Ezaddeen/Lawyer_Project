<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Observers\ActivityObserver;
use App\Models\Document;
use App\Models\User;

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
        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/vendor/livewire/livewire.js', $handle);
        // });
            Document::observe(ActivityObserver::class);
            User::observe(ActivityObserver::class);

    }
}
