<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailLeadNotifier
{
    public function send(Lead $lead): void
    {
        $to = (string) env('LEADS_NOTIFY_EMAIL', '');
        if ($to === '') {
            return;
        }

        $subject = 'Новая заявка с сайта #' . $lead->id;
        $lines = [
            'Новая заявка с сайта',
            'ID: ' . $lead->id,
            'Имя: ' . $lead->name,
            'Телефон: ' . $lead->phone,
        ];

        if (! empty($lead->urgency)) {
            $lines[] = 'Срочность: ' . $lead->urgency;
        }
        if (! empty($lead->location)) {
            $lines[] = 'Район: ' . $lead->location;
        }
        if (! empty($lead->service_type)) {
            $lines[] = 'Тип работ: ' . $lead->service_type;
        }
        if (! empty($lead->comment)) {
            $lines[] = 'Комментарий: ' . $lead->comment;
        }

        $body = implode("\n", $lines);

        try {
            Mail::raw($body, static function ($message) use ($to, $subject): void {
                $message->to($to)->subject($subject);
            });
        } catch (\Throwable $e) {
            Log::warning('Email lead notification failed', [
                'error' => $e->getMessage(),
                'lead_id' => $lead->id,
            ]);
        }
    }
}
