<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'seo_page_slug',
        'short_description',
        'price_from',
        'icon',
        'image_path',
        'cta_label',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class, 'recommended_service_id');
    }
}
