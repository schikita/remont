<?php

namespace App\Services;

use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadSubmissionService
{
    public function __construct(
        private readonly ViberLeadNotifier $viberNotifier,
        private readonly EmailLeadNotifier $emailNotifier,
    ) {}

    public function create(array $data, Request $request): Lead
    {
        $utm = [
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'utm_term' => $request->query('utm_term'),
            'utm_content' => $request->query('utm_content'),
        ];

        $lead = Lead::query()->create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'comment' => $data['comment'] ?? null,
            'service_type' => $data['service_type'] ?? null,
            'urgency' => $data['urgency'] ?? null,
            'location' => $data['location'] ?? null,
            'form_source' => $data['form_source'] ?? 'landing',
            'status' => LeadStatus::New,
            ...$utm,
        ]);

        $this->viberNotifier->send($lead);
        $this->emailNotifier->send($lead);

        return $lead;
    }
}
