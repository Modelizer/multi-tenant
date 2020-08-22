<?php

namespace Modelizer\MultiTenant;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modelizer\MultiTenent\Commands\RegisterPartner;

class MultiTenantServiceProvider extends ServiceProvider
{
    /**
     * @void
     */
    public function register()
    {
        $this->registerConfig();
        $this->identifyPartnerBySubDomain();
        $this->loadMigrationsFrom(__DIR__ . '../database/migrations');
        $this->commands([
            RegisterPartner::class,
        ]);
    }

    /**
     * After identifying partner from sub domain we also need to bind the partner details to application
     * container
     * @void
     */
    public function identifyPartnerBySubDomain()
    {
        $this->app->singleton('partner', function (Application $app) {
            $partner = Partner::whereHas('hostnames', function ($q) {
                return $q->where('fqdn', fqdn());
            })->first();

            // When we have sub domain in the url but partner is not registered with us then abort the request.
            if (sub_domain() && ! $partner) {
                abort(404);
            }

            return $partner;
        });
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../stubs/multi-tenant.php' => config_path('multi-tenant.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../stubs/multi-tenant.php', 'multi-tenant'
        );
    }
}
