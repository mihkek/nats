<?php

    namespace Mirronix\LogGlobal;

    use Illuminate\Support\ServiceProvider as Provider;

    class ServiceProvider extends Provider {
        public function boot() {
            $this->loadMigrationsFrom(__DIR__.'/database/migrations');
            $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        }

        public function register() {

        }
    }