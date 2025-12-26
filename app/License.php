<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class License extends Model
{
    protected $fillable = [
        'license_key',
        'feature',
        'is_active',
        'last_checked_at',
        'expires_at',
        'api_response',
        'api_url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_checked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if license is valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && Carbon::now()->greaterThan($this->expires_at)) {
            return false;
        }

        return true;
    }

    /**
     * Check if license needs to be refreshed (checked more than 1 hour ago)
     */
    public function needsRefresh()
    {
        if (!$this->last_checked_at) {
            return true;
        }

        return Carbon::now()->diffInHours($this->last_checked_at) >= 1;
    }
}
