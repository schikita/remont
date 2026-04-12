<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image_path',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image_path',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
