<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Multi-Guard Logout Trait
 *
 * Replaces Hesto\MultiAuth\Traits\LogsoutGuard for Laravel 7 compatibility
 *
 * This trait provides logout functionality for multi-guard authentication systems.
 * It detects the current guard, logs out the user, invalidates the session,
 * and redirects to the appropriate login page.
 *
 * Usage:
 * - Controller must implement a guard() method that returns the guard instance
 * - Trait will detect guard name and redirect to {guard}/login
 */
trait MultiGuardLogout
{
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Get the guard instance (controllers must define guard() method)
        $guard = $this->guard();

        // Get the guard name for redirect purposes
        $guardName = $this->getGuardName();

        // Log out the user from the specific guard
        $guard->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token for security
        $request->session()->regenerateToken();

        // Determine the redirect path based on guard
        $redirectPath = $this->getLogoutRedirectPath($guardName);

        return redirect($redirectPath);
    }

    /**
     * Get the guard name from the guard instance
     *
     * @return string
     */
    protected function getGuardName()
    {
        $guard = $this->guard();

        // Check all configured guards to find which one matches
        foreach (config('auth.guards') as $guardName => $guardConfig) {
            if ($guard === Auth::guard($guardName)) {
                return $guardName;
            }
        }

        // Default to 'web' if not found
        return 'web';
    }

    /**
     * Get the redirect path after logout based on guard name
     *
     * @param  string  $guardName
     * @return string
     */
    protected function getLogoutRedirectPath($guardName)
    {
        // Map guard names to their login paths
        $redirectPaths = [
            'admin' => '/admin/login',
            'customer' => '/customer/login',
            'web' => '/login',
        ];

        // Return the appropriate redirect path, default to /login
        return $redirectPaths[$guardName] ?? '/login';
    }

    /**
     * Get the guard to be used during logout.
     *
     * This method should be overridden in the controller.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    abstract protected function guard();
}
