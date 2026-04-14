<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ViberLeadNotifier
{
    public function send(Lead $lead): void
    {
        $token = (string) config('services.viber.bot_token', '');
        $receiver = (string) config('services.viber.receiver_id', '');

        if ($token === '' || $receiver === '') {
            return;
        }

        $message = $this->buildMessage($lead);

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'X-Viber-Auth-Token' => $token,
                    'Content-Type' => 'application/json',
                ])
                ->post('https://chatapi.viber.com/pa/send_message', [
                    'receiver' => $receiver,
                    'min_api_version' => 7,
                    'sender' => [
                        'name' => (string) config('app.name', 'Website'),
                    ],
                    'type' => 'text',
                    'text' => $message,
                ]);

            if (! $response->successful()) {
                Log::warning('Viber lead notification failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'lead_id' => $lead->id,
                ]);
            }
        } catch (\Throwable $e) {
            Log::warning('Viber lead notification exception', [
                'error' => $e->getMessage(),
                'lead_id' => $lead->id,
            ]);
        }
    }

    private function buildMessage(Lead $lead): string
    {
        $parts = [
            'Новая заявка с сайта',
            "Имя: {$lead->name}",
            "Телефон: {$lead->phone}",
        ];

        if (! empty($lead->urgency)) {
            $parts[] = "Срочность: {$lead->urgency}";
        }
        if (! empty($lead->location)) {
            $parts[] = "Район: {$lead->location}";
        }
        if (! empty($lead->service_type)) {
            $parts[] = "Тип работ: {$lead->service_type}";
        }
        if (! empty($lead->comment)) {
            $parts[] = "Комментарий: {$lead->comment}";
        }

        return implode("\n", $parts);
    }
}
