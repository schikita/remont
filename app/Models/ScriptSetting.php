<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScriptSetting extends Model
{
    protected $fillable = [
        'google_analytics_id',
        'google_tag_manager_id',
        'yandex_metrika_id',
        'head_scripts',
        'body_start_scripts',
        'body_end_scripts',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
