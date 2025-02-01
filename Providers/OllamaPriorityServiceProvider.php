<?php

namespace Modules\OllamaPriority\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\OllamaPriority\Module;

class OllamaPriorityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        \App\Module::register(Module::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Routen laden
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        // Views laden
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'ollama_priority');
    }
}
