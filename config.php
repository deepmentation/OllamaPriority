<?php

return [
    // Ollama Server Konfiguration
    'server_url' => env('OLLAMA_SERVER_URL', 'http://localhost:11434'),
    'model' => env('OLLAMA_MODEL', 'gemma2:2b'),
    
    // Prioritätsstufen
    'priority_levels' => [
        1 => 'Niedrig',
        2 => 'Normal',
        3 => 'Hoch',
        4 => 'Dringend',
        5 => 'Kritisch'
    ],
    
    // Systemanweisung für Ollama
    'system_prompt' => 'Analysiere den folgenden E-Mail-Text und bewerte die Priorität auf einer Skala von 1-5, wobei 1 niedrig und 5 kritisch ist. Berücksichtige dabei Faktoren wie Dringlichkeit, Wichtigkeit des Absenders, verwendete Schlüsselwörter und Tonfall. Gib nur die Zahl zurück.',
];
