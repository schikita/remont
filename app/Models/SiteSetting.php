<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_path',
        'favicon_path',
        'header_cta_label',
        'header_messenger_label',
        'footer_cta_label',
        'footer_note',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
