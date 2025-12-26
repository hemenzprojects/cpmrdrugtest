# License Feature for Evaluate Report Functionality

## Overview
This document explains how to configure and use the license feature that controls access to the "Evaluate Report" functionality in the HOD Office.

## Features Implemented

1. **License Database Table** - Stores license information including:
   - License key
   - Feature name (default: 'evaluate_report')
   - Active status
   - Expiration date
   - API URL for license verification
   - Last API check timestamp

2. **LicenseService** - Provides methods to:
   - Check if evaluate reports feature is licensed
   - Refresh license from external API
   - Configure license settings
   - Get license status information

3. **Middleware Protection** - Routes protected:
   - `/micro/hod_office/checkhodsign`
   - `/micro/hod_office/evaluatereport/{id}`
   - `/micro/hod_office/finalapproval/checkhodsign`
   - `/micro/hod_office/finalapproval/evaluatereport/{id}`
   - `/pharm/hod_office/checkhodsign`
   - `/pharm/hod_office/evaluatereport/{id}`
   - `/pharm/hod_office/finalapproval/checkhodsign`
   - `/pharm/hod_office/finalapproval/evaluatereport/{id}`
   - `/phyto/hod_office/checkhodsign`
   - `/phyto/hod_office/evaluatereport/{id}`

4. **UI Updates** - The "Evaluate Report" button:
   - Shows as disabled with lock icon when unlicensed
   - Displays error message when license is invalid
   - Works normally when license is active

## Setup Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Configure License via Tinker

```bash
php artisan tinker
```

Then run:
```php
use App\Services\LicenseService;

// Configure license with your API details
LicenseService::configureLicense(
    'YOUR_LICENSE_KEY',           // Your license key
    'https://your-api.com/verify', // Your license verification API URL
    'evaluate_report'              // Feature name
);
```

### 3. Manual License Configuration (Alternative)

You can also insert directly into the database:

```sql
INSERT INTO licenses (license_key, feature, is_active, api_url, expires_at, created_at, updated_at)
VALUES (
    'YOUR_LICENSE_KEY',
    'evaluate_report',
    1,  -- Set to 1 to activate immediately without API check
    'https://your-api.com/verify',
    '2026-12-31 23:59:59',  -- Expiration date
    NOW(),
    NOW()
);
```

## API Requirements

### License Verification API

Your license verification API should:

**Request:**
- Method: GET
- Parameters:
  - `license_key`: The license key to verify
  - `feature`: The feature name (evaluate_report)

**Response (JSON):**
```json
{
    "is_active": true,
    "expires_at": "2026-12-31 23:59:59"
}
```

**Example Response for Inactive License:**
```json
{
    "is_active": false,
    "expires_at": null
}
```

## How It Works

1. **Automatic License Refresh:**
   - License is checked against the API every hour
   - If API call fails, license is marked as inactive for safety
   - Last check timestamp is recorded

2. **Access Control:**
   - When a user tries to evaluate a report, middleware checks license status
   - If license is invalid/expired, user is redirected back with error message
   - If license is valid, evaluation proceeds normally

3. **UI Behavior:**
   - The "Evaluate Report" button checks license status
   - If unlicensed: Button shows as disabled with lock icon
   - If licensed: Button works normally

## Checking License Status

### Via Tinker:
```bash
php artisan tinker
```

```php
use App\Services\LicenseService;

// Check if feature is licensed
LicenseService::canEvaluateReports();  // Returns true/false

// Get detailed license status
LicenseService::getLicenseStatus();
```

### Output Example:
```php
[
    "exists" => true,
    "is_active" => true,
    "expires_at" => "2026-12-31 23:59:59",
    "last_checked_at" => "2025-12-20 18:30:00",
    "message" => "License is active"
]
```

## Testing Without API

For testing purposes, you can activate a license without API verification:

```sql
UPDATE licenses
SET is_active = 1,
    expires_at = '2026-12-31 23:59:59',
    last_checked_at = NOW()
WHERE feature = 'evaluate_report';
```

## Troubleshooting

### License not working after configuration
1. Clear config cache: `php artisan config:clear`
2. Check license table: `SELECT * FROM licenses WHERE feature = 'evaluate_report';`
3. Verify API URL is correct and accessible

### Button still shows as unlicensed
1. Clear view cache: `php artisan view:clear`
2. Check browser console for JavaScript errors
3. Verify ViewComposer is registered in `AppServiceProvider`

### API errors in logs
1. Check `storage/logs/laravel.log` for API errors
2. Verify API endpoint is reachable
3. Check API response format matches expected JSON structure

## Files Modified/Created

- `database/migrations/2025_12_20_180839_create_licenses_table.php` - License table migration
- `app/License.php` - License model
- `app/Services/LicenseService.php` - License service
- `app/Http/Middleware/CheckEvaluateLicense.php` - License middleware
- `app/Http/Kernel.php` - Middleware registration
- `app/Http/ViewComposers/LicenseComposer.php` - View composer for license data
- `app/Providers/AppServiceProvider.php` - View composer registration
- `routes/web.php` - Route middleware applied
- `resources/views/admin/micro/hodoffice/showreport.blade.php` - Updated button logic

## Security Notes

- License is checked server-side (middleware)
- UI changes are only for UX - real security is in middleware
- Failed API calls default to inactive for safety
- License key is stored in database (consider encryption for production)

## Support

For issues or questions, contact your system administrator or development team.