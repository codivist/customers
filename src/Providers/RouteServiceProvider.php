<?php

namespace Codivist\Modules\Customers\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Codivist\Modules\Customers\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            $router->middleware('web')->group(function (Router $router) {

                // Registration
                $router->get('register', 'RegisterController@showRegistrationForm')->name('register');
                $router->post('register', 'RegisterController@register');
                $router->get('activate/{token}', 'RegisterController@activate')->name('activate');

                // Login
                $router->get('login', 'LoginController@showLoginForm')->name('login');
                $router->post('login', 'LoginController@login');

                // Logout
                $router->post('logout', 'LoginController@logout')->name('logout');

                // Request new password
                $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
                $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');

                // Set new password
                $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
                $router->post('password/reset', 'ResetPasswordController@reset');
            });

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('customers', 'AdminController@index')->name('admin::index-customers')->middleware('can:see-all-customers');
                $router->get('customers/create', 'AdminController@create')->name('admin::create-customer')->middleware('can:create-customer');
                $router->get('customers/{customer}/edit', 'AdminController@edit')->name('admin::edit-customer')->middleware('can:update-customer');
                $router->post('customers', 'AdminController@store')->name('admin::store-customer')->middleware('can:create-customer');
                $router->put('customers/{customer}', 'AdminController@update')->name('admin::update-customer')->middleware('can:update-customer');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('customers', 'ApiController@index')->middleware('can:see-all-customers');
                    $router->post('customers/current/updatepreferences', 'ApiController@updatePreferences')->middleware('can:update-preferences');
                    $router->patch('customers/{customer}', 'ApiController@updatePartial')->middleware('can:update-customer');
                    $router->delete('customers/{customer}', 'ApiController@destroy')->middleware('can:delete-customer');
                });
            });
        });
    }
}
