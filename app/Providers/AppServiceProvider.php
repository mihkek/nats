<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Providers\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	Schema::defaultStringLength(191);
        Blade::directive('lang', function ($expression) {
            return "<?php echo Lang::has($expression) ? Lang::get($expression) : '<span class=\"no_translate\" data-expression=\"' . htmlspecialchars($expression) . '\">' . $expression . '</span>'; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
