<?php

    namespace Mirronix\FieldAccess;

    use Illuminate\Support\ServiceProvider as Provider;

    class ServiceProvider extends Provider {
        public function boot() {
            $this->loadMigrationsFrom(__DIR__.'/database/migrations');
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');
            $this->publishes([
                __DIR__.'/resources/assets' => resource_path('assets/vendor/mirronix/fieldaccess'),
            ], 'assets');
        }

        public function register() {
        }
    }