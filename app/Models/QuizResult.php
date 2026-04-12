<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $fillable = [
        'title',
        'description',
        'min_score',
        'max_score',
        'recommended_service_id',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function recommendedService(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'recommended_service_id');
    }
}
