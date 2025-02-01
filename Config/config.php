<?php

return [
    // Ollama Server Konfiguration
    'server_url' => [
        'default' => env('OLLAMA_SERVER_URL', 'http://localhost:11434'),
        'type' => 'text',
        'description' => 'URL des Ollama-Servers',
    ],
    
    'model' => [
        'default' => env('OLLAMA_MODEL', 'mistral'),
        'type' => 'text',
        'description' => 'Name des zu verwendenden Ollama-Modells',
    ],
    
    // Prioritätsstufen
    'priority_levels' => [
        'default' => [
            1 => __('Niedrig'),
            2 => __('Normal'),
            3 => __('Hoch'),
            4 => __('Dringend'),
            5 => __('Kritisch')
        ],
    ],
    
    // Systemanweisung für Ollama
    'system_prompt' => [
        'default' => 'Analysiere den folgenden E-Mail-Text und bewerte die Priorität auf einer Skala von 1-5, wobei 1 niedrig und 5 kritisch ist. Berücksichtige dabei Faktoren wie Dringlichkeit, Wichtigkeit des Absenders, verwendete Schlüsselwörter und Tonfall. Gib nur die Zahl zurück.',
        'type' => 'textarea',
        'description' => 'Anweisung für das KI-Modell zur Priorisierung',
    ],
];

?>
