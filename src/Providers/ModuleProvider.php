<?php

namespace Codivist\Modules\Customers\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Codivist\Modules\Customers\Composers\SidebarViewComposer;
use Codivist\Modules\Customers\Facades\Customers;
use Codivist\Modules\Customers\Repositories\EloquentCustomer;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'codivist.customers'
        );
        $this->mergeConfigFrom(
            __DIR__.'/../config/permissions.php', 'codivist.permissions'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('codivist.modules', array_merge(['customers' => []], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'customers');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/customers'),
        ], 'views');

        AliasLoader::getInstance()->alias('Customers', Customers::class);

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Customers', EloquentCustomer::class);
    }
}
