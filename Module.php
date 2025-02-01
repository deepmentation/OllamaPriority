<?php

namespace Modules\OllamaPriority;

use App\Providers\Extension;

class Module extends Extension
{
    /**
     * Modulname.
     */
    public const NAME = 'ollama-priority';

    /**
     * Registriere die Modulkonfiguration.
     */
    public function init()
    {
        // Konfigurationsdatei laden
        \Config::set('ollama_priority', include(__DIR__.'/config.php'));

        // Middleware für die Priorisierung registrieren
        $this->app['router']->pushMiddlewareToGroup('web', 
            \Modules\OllamaPriority\Http\Middleware\ProcessIncomingMail::class
        );

        // CSS für die Prioritätsanzeige laden
        \Eventy::addFilter('stylesheets', function($styles) {
            $styles[] = \Module::getPublicPath(self::NAME).'/css/priority.css';
            return $styles;
        });

        // Event Listener für die Mail-Übersicht registrieren
        \Eventy::addFilter('conversations.table_header', [$this, 'addPriorityColumn'], 20, 1);
        \Eventy::addFilter('conversations.table_row', [$this, 'addPriorityData'], 20, 2);
    }

    /**
     * Fügt die Prioritätsspalte zum Header der Mail-Übersicht hinzu.
     */
    public function addPriorityColumn($headers)
    {
        $headers['priority'] = __('Priority');
        return $headers;
    }

    /**
     * Fügt die Prioritätsdaten zu jeder Zeile hinzu.
     */
    public function addPriorityData($html, $conversation)
    {
        // Priorität aus den Metadaten holen
        $priority = $conversation->getMeta('ollama_priority');
        if (!$priority) {
            $priority = '-';
        }

        // HTML für die Prioritätsspalte mit Prioritätsklasse
        $priorityClass = is_numeric($priority) ? 'priority-' . $priority : '';
        $html['priority'] = '<td class="conversation-priority ' . $priorityClass . '">'.$priority.'</td>';
        return $html;
    }
    }
}
