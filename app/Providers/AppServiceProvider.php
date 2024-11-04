<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\Title;
use App\Models\{Shelf,Section};
use Illuminate\Support\Facades\View;

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
        // Blade::component('title',Title::class);
         $sections = Section::pluck('s_name','id')->toArray();
         $shelves = Shelf::pluck('sh_name','id')->toArray();
         View::share('sections', $sections);
         View::share('shelves', $shelves);
    }
}
