# Ollama Priority Module für FreeScout

Dieses Modul verwendet Ollama zur automatischen Priorisierung von E-Mails basierend auf deren Inhalt.

## Features

- Automatische Priorisierung eingehender E-Mails mit Hilfe von Ollama
- Neue Spalte in der Mail-Übersicht zur Anzeige der Priorität
- Farbliche Kennzeichnung verschiedener Prioritätsstufen
- Konfigurierbare Ollama-Server-Einstellungen

## Installation

1. Kopieren Sie den Modulordner in das `Modules`-Verzeichnis Ihrer FreeScout-Installation
2. Aktivieren Sie das Modul in der FreeScout-Verwaltung unter "Module"
3. Konfigurieren Sie die Ollama-Server-Einstellungen:
   - Server URL (Standard: http://localhost:11434)
   - Modell (Standard: mistral)
   - System Prompt (kann angepasst werden für bessere Priorisierung)

## Prioritätsstufen

Das Modul verwendet 5 Prioritätsstufen:

1. Kritisch (Rot)
2. Dringend (Orange)
3. Hoch (Gelb)
4. Normal (Grün)
5. Niedrig (Grau)

## Voraussetzungen

- FreeScout Installation
- Laufender Ollama-Server mit installiertem Modell
- PHP >= 7.4
- Laravel Framework

## Konfiguration

Die Konfiguration kann in der `config.php` angepasst werden:

```php
'server_url' => env('OLLAMA_SERVER_URL', 'http://localhost:11434'),
'model' => env('OLLAMA_MODEL', 'mistral'),
'system_prompt' => 'Angepasste Anweisung zur Priorisierung...'
```

Alternativ können diese Werte auch über Umgebungsvariablen gesetzt werden:

```env
OLLAMA_SERVER_URL=http://localhost:11434
OLLAMA_MODEL=mistral
```

## Lizenz

MIT License
