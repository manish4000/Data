<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $activeSiteLanguages = \App\Models\SiteLanguage::where('status', 'Active')->get();
      
        \View::share(['activeLanguageData'=> $activeSiteLanguages]);
    }
}
