<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'body',
        'image_path',
        'stats',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'stats' => 'array',
            'is_published' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
