<?php

namespace Devsofpixel7\Notificared;

use Illuminate\Support\ServiceProvider;

class NotificareServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Let our framework Ioc Container know about our Controller
        //$this->app->make('Devsofpixel7\Notificare\NotificareController');
        $this->app->make('Devsofpixel7\Notificare\Notification');
    }

}