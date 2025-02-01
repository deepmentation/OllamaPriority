<?php

namespace Modules\OllamaPriority\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

define('OLLAMA_PRIORITY_MODULE', 'ollamapriority');

class OllamaPriorityServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // Middleware für die Priorisierung registrieren
        $this->app['router']->pushMiddlewareToGroup('web', 
            \Modules\OllamaPriority\Http\Middleware\ProcessIncomingMail::class
        );

        // CSS für die Prioritätsanzeige laden
        \Eventy::addFilter('stylesheets', function($value) {
            array_push($value, '/modules/'.OLLAMA_PRIORITY_MODULE.'/css/priority.css');
            return $value;
        }, 20, 1);

        // Event Listener für die Mail-Übersicht registrieren
        \Eventy::addFilter('conversations.table_header', function($headers) {
            $headers['priority'] = __('Priority');
            return $headers;
        }, 20, 1);

        \Eventy::addFilter('conversations.table_row', function($html, $conversation) {
            // Priorität aus den Metadaten holen
            $priority = $conversation->getMeta('ollama_priority');
            if (!$priority) {
                $priority = '-';
            }

            // HTML für die Prioritätsspalte mit Prioritätsklasse
            $priorityClass = is_numeric($priority) ? 'priority-' . $priority : '';
            $html['priority'] = '<td class="conversation-priority ' . $priorityClass . '">'.$priority.'</td>';
            return $html;
        }, 20, 2);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('ollamapriority.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'ollamapriority'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/ollamapriority');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/ollamapriority';
        }, \Config::get('view.paths')), [$sourcePath]), 'ollamapriority');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/ollamapriority');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'ollamapriority');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'ollamapriority');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

?>
