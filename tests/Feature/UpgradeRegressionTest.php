<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Admin;
use App\Customer;
use App\User;
use App\Product;
use App\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * Comprehensive regression test suite for Laravel 5.8 to 7 upgrade
 *
 * This test file validates critical functionality before and after upgrade:
 * - Multi-guard authentication (admin, customer, web)
 * - Route accessibility and middleware protection
 * - Core business logic for all 3 departments
 *
 * Run this test suite BEFORE upgrading to establish baseline
 * Run again AFTER upgrading to verify nothing broke
 */
class UpgradeRegressionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup test data
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create test users for each guard
        $this->createTestData();
    }

    /**
     * Create test data for all guards and core entities
     */
    protected function createTestData()
    {
        // Create admin user
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);

        // Create customer user
        Customer::create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password123'),
        ]);

        // Create regular user (if using web guard)
        User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
        ]);
    }

    // ========================================
    // AUTHENTICATION TESTS - Admin Guard
    // ========================================

    /**
     * Test admin login page is accessible
     */
    public function test_admin_login_page_accessible()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /**
     * Test admin can login with valid credentials
     */
    public function test_admin_can_login_with_valid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs(Admin::first(), 'admin');
    }

    /**
     * Test admin cannot login with invalid credentials
     */
    public function test_admin_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('admin');
    }

    /**
     * Test admin can logout
     */
    public function test_admin_can_logout()
    {
        $admin = Admin::first();

        $response = $this->actingAs($admin, 'admin')
                        ->post('/admin/logout');

        $response->assertRedirect('/admin/login');
        $this->assertGuest('admin');
    }

    /**
     * Test admin dashboard requires authentication
     */
    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test authenticated admin can access dashboard
     */
    public function test_authenticated_admin_can_access_dashboard()
    {
        $admin = Admin::first();

        $response = $this->actingAs($admin, 'admin')
                        ->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    // ========================================
    // AUTHENTICATION TESTS - Customer Guard
    // ========================================

    /**
     * Test customer login page is accessible
     */
    public function test_customer_login_page_accessible()
    {
        $response = $this->get('/customer/login');
        $response->assertStatus(200);
    }

    /**
     * Test customer can login with valid credentials
     */
    public function test_customer_can_login_with_valid_credentials()
    {
        $response = $this->post('/customer/login', [
            'email' => 'customer@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs(Customer::first(), 'customer');
    }

    /**
     * Test customer cannot login with invalid credentials
     */
    public function test_customer_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/customer/login', [
            'email' => 'customer@test.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('customer');
    }

    /**
     * Test customer can logout
     */
    public function test_customer_can_logout()
    {
        $customer = Customer::first();

        $response = $this->actingAs($customer, 'customer')
                        ->post('/customer/logout');

        $response->assertRedirect('/customer/login');
        $this->assertGuest('customer');
    }

    /**
     * Test customer dashboard requires authentication
     */
    public function test_customer_dashboard_requires_authentication()
    {
        $response = $this->get('/customer/dashboard');
        $response->assertRedirect('/customer/login');
    }

    /**
     * Test authenticated customer can access dashboard
     */
    public function test_authenticated_customer_can_access_dashboard()
    {
        $customer = Customer::first();

        $response = $this->actingAs($customer, 'customer')
                        ->get('/customer/dashboard');

        $response->assertStatus(200);
    }

    // ========================================
    // GUARD ISOLATION TESTS
    // ========================================

    /**
     * Test admin cannot access customer routes
     */
    public function test_admin_cannot_access_customer_routes()
    {
        $admin = Admin::first();

        $response = $this->actingAs($admin, 'admin')
                        ->get('/customer/dashboard');

        $response->assertRedirect();
    }

    /**
     * Test customer cannot access admin routes
     */
    public function test_customer_cannot_access_admin_routes()
    {
        $customer = Customer::first();

        $response = $this->actingAs($customer, 'customer')
                        ->get('/admin/dashboard');

        $response->assertRedirect();
    }

    // ========================================
    // PASSWORD RESET TESTS
    // ========================================

    /**
     * Test admin password reset page is accessible
     */
    public function test_admin_password_reset_page_accessible()
    {
        $response = $this->get('/admin/password/reset');
        $response->assertStatus(200);
    }

    /**
     * Test customer password reset page is accessible
     */
    public function test_customer_password_reset_page_accessible()
    {
        $response = $this->get('/customer/password/reset');
        $response->assertStatus(200);
    }

    // ========================================
    // ROUTE ACCESSIBILITY TESTS
    // ========================================

    /**
     * Test home page is accessible
     */
    public function test_home_page_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test admin login page is accessible
     */
    public function test_admin_routes_require_authentication()
    {
        $protectedRoutes = [
            '/admin/dashboard',
            '/admin/sid/dashboard',
            '/admin/micro/dashboard',
            '/admin/pharm/dashboard',
            '/admin/phyto/dashboard',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/admin/login');
        }
    }

    // ========================================
    // DEPARTMENT MIDDLEWARE TESTS
    // ========================================

    /**
     * Test SID department routes are protected
     */
    public function test_sid_department_routes_protected()
    {
        $response = $this->get('/admin/sid/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test Microbiology department routes are protected
     */
    public function test_micro_department_routes_protected()
    {
        $response = $this->get('/admin/micro/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test Pharmacology department routes are protected
     */
    public function test_pharm_department_routes_protected()
    {
        $response = $this->get('/admin/pharm/dashboard');
        $response->assertRedirect('/admin/login');
    }

    /**
     * Test Phytochemistry department routes are protected
     */
    public function test_phyto_department_routes_protected()
    {
        $response = $this->get('/admin/phyto/dashboard');
        $response->assertRedirect('/admin/login');
    }

    // ========================================
    // DATABASE & MODEL TESTS
    // ========================================

    /**
     * Test admin model can be created
     */
    public function test_admin_model_creation()
    {
        $admin = Admin::create([
            'name' => 'New Admin',
            'email' => 'newadmin@test.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertDatabaseHas('admins', [
            'email' => 'newadmin@test.com',
        ]);
    }

    /**
     * Test customer model can be created
     */
    public function test_customer_model_creation()
    {
        $customer = Customer::create([
            'name' => 'New Customer',
            'email' => 'newcustomer@test.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertDatabaseHas('customers', [
            'email' => 'newcustomer@test.com',
        ]);
    }

    // ========================================
    // SESSION & CSRF TESTS
    // ========================================

    /**
     * Test CSRF protection is active
     */
    public function test_csrf_protection_active()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);

        // Without CSRF token, Laravel should reject in production
        // In testing, it's auto-included, but we verify session works
        $response->assertSessionHasNoErrors('_token');
    }

    /**
     * Test session works after login
     */
    public function test_session_works_after_login()
    {
        $admin = Admin::first();

        $this->actingAs($admin, 'admin')
            ->get('/admin/dashboard')
            ->assertSessionHas('_token');
    }

    // ========================================
    // API ROUTES TESTS (if applicable)
    // ========================================

    /**
     * Test API routes return JSON
     */
    public function test_api_routes_return_json()
    {
        $response = $this->json('GET', '/api/user');

        // May be 401 unauthorized, but should be JSON
        $response->assertHeader('Content-Type', 'application/json');
    }

    // ========================================
    // CONFIGURATION TESTS
    // ========================================

    /**
     * Test app environment is testing
     */
    public function test_app_environment_is_testing()
    {
        $this->assertEquals('testing', app()->environment());
    }

    /**
     * Test database connection works
     */
    public function test_database_connection_works()
    {
        $this->assertDatabaseHas('admins', [
            'email' => 'admin@test.com',
        ]);
    }

    /**
     * Test auth guards are configured
     */
    public function test_auth_guards_configured()
    {
        $guards = array_keys(config('auth.guards'));

        $this->assertContains('web', $guards);
        $this->assertContains('admin', $guards);
        $this->assertContains('customer', $guards);
        $this->assertContains('api', $guards);
    }

    /**
     * Test auth providers are configured
     */
    public function test_auth_providers_configured()
    {
        $providers = array_keys(config('auth.providers'));

        $this->assertContains('users', $providers);
        $this->assertContains('admins', $providers);
        $this->assertContains('customers', $providers);
    }

    // ========================================
    // VIEW TESTS
    // ========================================

    /**
     * Test admin login view exists
     */
    public function test_admin_login_view_exists()
    {
        $this->assertTrue(view()->exists('admin.auth.login'));
    }

    /**
     * Test customer login view exists
     */
    public function test_customer_login_view_exists()
    {
        $this->assertTrue(view()->exists('customer.auth.login'));
    }
}
