<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LeadStatus: string implements HasLabel
{
    case New = 'new';
    case InProgress = 'in_progress';
    case Done = 'done';
    case Spam = 'spam';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новая',
            self::InProgress => 'В работе',
            self::Done => 'Завершена',
            self::Spam => 'Спам',
            self::Cancelled => 'Отменена',
        };
    }

    public function getLabel(): ?string
    {
        return $this->label();
    }
}
