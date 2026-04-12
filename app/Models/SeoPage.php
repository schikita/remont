<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SeoPage extends Model
{
    protected $fillable = [
        'slug',
        'meta_title',
        'meta_description',
        'h1',
        'intro',
        'content',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public static function path(string $slug): string
    {
        return '/uslugi/'.$slug;
    }
}
