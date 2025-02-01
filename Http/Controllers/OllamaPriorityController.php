<?php

namespace Modules\OllamaPriority\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OllamaPriorityController extends Controller
{
    /**
     * Zeige die Konfigurationsseite.
     */
    public function showConfig()
    {
        $config = \Config::get('ollamapriority');
        
        return view('ollamapriority::config', [
            'config' => $config,
            'server_url' => $config['server_url']['default'],
            'model' => $config['model']['default'],
            'system_prompt' => $config['system_prompt']['default']
        ]);
    }

    /**
     * Speichere die Konfiguration.
     */
    public function saveConfig(Request $request)
    {
        $validated = $request->validate([
            'server_url' => 'required|url',
            'model' => 'required|string',
            'system_prompt' => 'required|string'
        ]);

        // Speichere die Einstellungen
        \Option::set('ollamapriority.server_url', $validated['server_url']);
        \Option::set('ollamapriority.model', $validated['model']);
        \Option::set('ollamapriority.system_prompt', $validated['system_prompt']);

        \Session::flash('flash_success_floating', __('Settings updated'));

        return redirect()->route('ollamapriority.config');
    }
}

?>
