<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'headline',
        'subheadline',
        'offer_text',
        'trust_badges',
        'urgency_label',
        'guarantee_label',
        'show_lead_form',
        'background_image_path',
        'gradient_preset',
    ];

    protected function casts(): array
    {
        return [
            'trust_badges' => 'array',
            'show_lead_form' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
