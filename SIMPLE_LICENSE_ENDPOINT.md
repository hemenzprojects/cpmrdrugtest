# Simple License Endpoint - Setup Guide

## 🎯 What You Need

A simple external URL that returns JSON with `is_active` as true or false.

---

## ✅ Option 1: Static JSON File (Easiest - 2 minutes)

### Step 1: Create a file called `license.json`:

```json
{
    "is_active": true
}
```

### Step 2: Upload it to any web server

**Free hosting options:**
- **GitHub Pages**: https://pages.github.com
- **Netlify**: https://netlify.com (drag & drop)
- **Vercel**: https://vercel.com
- Any web hosting you have
- https://www.npoint.io/account

### Step 3: Get the public URL

Example: `https://yourdomain.com/license.json`

### Step 4: Configure in your system

```bash
docker exec -it cpmr_drugtest_app php artisan tinker
```

```php
use App\Services\LicenseService;

LicenseService::configureLicense(
    'any-key-you-want',  // Doesn't matter for static file
    'https://yourdomain.com/license.json',  // Your JSON file URL
    'evaluate_report'
);
```

### To Expire License:
Just change the JSON file to:
```json
{
    "is_active": false
}
```

✅ **That's it!**

---

## ✅ Option 2: Simple PHP Script (More Control - 5 minutes)

### Step 1: Create `license-check.php`:

```php
<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// SIMPLE: Just change this value to control license
$licenseActive = true;  // Change to false when you want to expire

// Optional: Add expiration date logic
$expirationDate = '2026-12-31';
$isExpired = (strtotime($expirationDate) < time());

if ($isExpired) {
    $licenseActive = false;
}

// Return JSON
echo json_encode([
    'is_active' => $licenseActive,
    'expires_at' => $expirationDate . ' 23:59:59',
    'message' => $licenseActive ? 'License is active' : 'License has expired'
]);
?>
```

### Step 2: Upload to any PHP server

Example URL: `https://yourdomain.com/license-check.php`

### Step 3: Test it

Visit the URL in browser, you should see:
```json
{
    "is_active": true,
    "expires_at": "2026-12-31 23:59:59",
    "message": "License is active"
}
```

### Step 4: Configure in your system

```bash
docker exec -it cpmr_drugtest_app php artisan tinker
```

```php

php artisan tinker --execute="
  use App\Services\LicenseService;
  LicenseService::configureLicense(
      'your-license-key',
      'YOUR_NPOINT_URL_HERE',
      'evaluate_report'
  );
  echo 'License configured and DB updated!';
  "

use App\Services\LicenseService;

LicenseService::configureLicense(
    'your-license-key',  // Any value
    'https://yourdomain.com/license-check.php',
    'evaluate_report'
);
```

---

## ✅ Option 3: Even Simpler - Database Control

### Create `license-check.php` with database:

```php
<?php
header('Content-Type: application/json');

// Connect to a simple database
$conn = new mysqli('localhost', 'user', 'password', 'licenses_db');

// Check if license is active
$result = $conn->query("SELECT is_active FROM licenses WHERE id = 1");
$row = $result->fetch_assoc();

echo json_encode([
    'is_active' => (bool)$row['is_active']
]);
?>
```

Then you can turn license on/off via MySQL:

```sql
-- Activate license
UPDATE licenses SET is_active = 1 WHERE id = 1;

-- Deactivate license (will show "License is due")
UPDATE licenses SET is_active = 0 WHERE id = 1;
```

---

## 🎨 What Users Will See

### When License is Active (`is_active: true`):
- ✅ "Evaluate Report" button works normally
- ✅ No alerts or warnings

### When License Expires (`is_active: false`):
- ❌ Red alert at top: **"License Expired! Your license is due..."**
- ❌ "Evaluate Report" button is disabled with lock icon
- ❌ Shows "Evaluate Report (Unlicensed)"
- ❌ Middleware blocks any attempts to bypass

---

## 🧪 Testing

### Test with Active License:

1. Set your endpoint to return:
```json
{"is_active": true}
```

2. Visit the HOD office evaluate page
3. You should see the evaluate button working

### Test with Expired License:

1. Change endpoint to return:
```json
{"is_active": false}
```

2. Refresh the page
3. You should see:
   - Red "License Expired" alert at top
   - Disabled "Evaluate Report" button
   - Cannot click to evaluate

---

## 🔄 How Often Does It Check?

- System checks your endpoint **every 1 hour**
- If your endpoint is down → license becomes inactive (safe default)
- First check happens immediately when you configure

---

## 🚀 Quick Start (Fastest Way)

1. **Create this simple `license.json` file:**
```json
{"is_active": true}
```

2. **Upload to any free host** (GitHub Pages, Netlify, etc.)

3. **Get the URL** (e.g., `https://yourname.github.io/license.json`)

4. **Configure:**
```bash
docker exec -it cpmr_drugtest_app php artisan tinker
```
```php
use App\Services\LicenseService;
LicenseService::configureLicense('any-key', 'YOUR-URL-HERE', 'evaluate_report');
```

5. **Done!** Test it by visiting the HOD office page

---

## 📝 Summary

You just need:
1. ✅ A URL that returns `{"is_active": true}` or `{"is_active": false}`
2. ✅ That's literally it!

The system I built handles:
- ✅ Checking the endpoint every hour
- ✅ Blocking access when `is_active: false`
- ✅ Showing "License is due" alert
- ✅ Disabling the evaluate button
- ✅ Everything else automatically

---

Need help setting up the endpoint? Let me know which option you want and I can guide you through it!
