<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'work_schedule',
        'telegram_url',
        'whatsapp_url',
        'viber_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }
}
