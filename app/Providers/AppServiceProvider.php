<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Register License View Composer for HOD office views
        View::composer(
            [
                'admin.micro.hodoffice.showreport',
                'admin.micro.hodoffice.finalreport',
                'admin.micro.showreport',
                'admin.pharm.hodoffice.showreport',
                'admin.pharm.hodoffice.finalreport',
                'admin.phyto.hodoffice.showreport',
            ],
            \App\Http\ViewComposers\LicenseComposer::class
        );
    }
}
