<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'author',
        'body',
        'rating',
        'reviewed_on',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_on' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
