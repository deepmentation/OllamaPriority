<?php

// Hier können später zusätzliche Routen für das Modul hinzugefügt werden,
// zum Beispiel für eine Konfigurationsoberfläche oder API-Endpunkte.

Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'ollama-priority',
    'namespace' => 'Modules\OllamaPriority\Http\Controllers'
], function() {
    // Routen hier einfügen
});

?>
