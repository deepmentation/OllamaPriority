<?php

namespace Modules\OllamaPriority\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Conversation;
use Illuminate\Support\Facades\Log;

class ProcessIncomingMail
{
    /**
     * Verarbeite eingehende E-Mails und setze die Priorität.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Nur eingehende E-Mails verarbeiten
        if ($request->is('api/conversations/create*')) {
            try {
                // E-Mail-Inhalt aus dem Request extrahieren
                $emailContent = $request->input('body');
                $subject = $request->input('subject');
                
                // Vollständigen Text für die Analyse zusammenstellen
                $analysisText = "Betreff: {$subject}\n\nInhalt:\n{$emailContent}";
                
                // Ollama API aufrufen
                $response = Http::post(config('ollama_priority.server_url') . '/api/generate', [
                    'model' => config('ollama_priority.model'),
                    'prompt' => $analysisText,
                    'system' => config('ollama_priority.system_prompt'),
                    'stream' => false
                ]);

                if ($response->successful()) {
                    // Priorität aus der Antwort extrahieren (nur die Zahl)
                    $priority = (int) preg_replace('/[^1-5]/', '', $response->json('response'));
                    
                    // Priorität im Request setzen
                    $request->merge(['priority' => $priority]);

                    // Conversation ID aus der URL extrahieren
                    if (preg_match('/\/conversations\/(\d+)\//', $request->url(), $matches)) {
                        $conversationId = $matches[1];
                        $conversation = Conversation::find($conversationId);
                        if ($conversation) {
                            // Priorität in den Metadaten speichern
                            $conversation->setMeta('ollama_priority', $priority);
                            $conversation->save();
                        }
                    }
                    
                    Log::info('E-Mail Priorität gesetzt', [
                        'subject' => $subject,
                        'priority' => $priority
                    ]);
                } else {
                    Log::error('Ollama API Fehler', [
                        'status' => $response->status(),
                        'error' => $response->body()
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Fehler bei der E-Mail-Priorisierung', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $next($request);
    }
}
