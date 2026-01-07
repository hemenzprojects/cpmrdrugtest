<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Services\LicenseService;

class LicenseComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $licenseStatus = LicenseService::getLicenseStatus();

        $view->with('canEvaluateReports', LicenseService::canEvaluateReports());
        $view->with('licenseStatus', $licenseStatus);
        $view->with('licenseNotification', $licenseStatus['notification_message'] ?? null);
    }
}