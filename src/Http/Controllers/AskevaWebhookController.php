<?php

namespace Askeva\WhatsApp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Askeva\WhatsApp\Models\AskevaWebhook;
use Illuminate\Support\Facades\Log;

class AskevaWebhookController extends Controller
{
    /**
     * Verify the webhook challenge from WhatsApp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $mode         = $request->query('hub_mode');
        $token        = $request->query('hub_verify_token');
        $challenge    = $request->query('hub_challenge');

        $verifyToken = config('askeva.webhook_verify_token', config('askeva.token'));

        if ($mode === 'subscribe' && $token === $verifyToken) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    /**
     * Handle incoming webhook requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            
            // Basic extraction (you can customize this based on exact payload structure)
            // WhatsApp Cloud API typically has entry[0].changes[0].value
            $value = $payload['entry'][0]['changes'][0]['value'] ?? null;
            
            if ($value && isset($value['messages'][0])) {
                $message = $value['messages'][0];
                $contact = $value['contacts'][0] ?? null;
                $metadata = $value['metadata'] ?? null;

                AskevaWebhook::create([
                    'message_id' => $message['id'] ?? 'unknown',
                    'from_wa_id' => $message['from'] ?? 'unknown',
                    'from_name' => $contact['profile']['name'] ?? null,
                    'business_phone_number_id' => $metadata['phone_number_id'] ?? 'unknown',
                    'display_phone_number' => $metadata['display_phone_number'] ?? null,
                    'body' => $message['text']['body'] ?? json_encode($message),
                    'raw_payload' => $payload,
                    'received_at' => now(),
                ]);
            } else {
                // If the structure is different or it's a status update, we just log it as a raw payload for now
                AskevaWebhook::create([
                    'message_id' => 'status-update-' . time(),
                    'from_wa_id' => 'unknown',
                    'from_name' => null,
                    'business_phone_number_id' => 'unknown',
                    'display_phone_number' => null,
                    'body' => 'Non-message webhook payload (e.g., status update)',
                    'raw_payload' => $payload,
                    'received_at' => now(),
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error processing Askeva Webhook: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
