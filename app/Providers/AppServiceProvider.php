<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( Schema::hasTable( 'settings' ) )
        {
            $setting = Setting::find( 1 );
            view()->share( 'config', $setting );
        }

        if ( Schema::hasTable( 'categories' ) )
        {
            $category = Category::whereLevel( 0 )->get();

            view()->share( 'menu_category', $category );
        }
    }
}