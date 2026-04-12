<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'comment',
        'service_type',
        'urgency',
        'location',
        'form_source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'status',
        'manager_note',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
        ];
    }
}
