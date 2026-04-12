<?php

namespace App\Support;

/**
 * Фоновые градиенты для секций лендинга и Hero (значения хранятся в админке).
 */
final class SectionGradient
{
    /**
     * @return array<string, string>
     */
    public static function sectionOptions(): array
    {
        return [
            'default' => 'Лёгкий (серо-белый + мята)',
            'brand_soft' => 'Мятный мягкий',
            'brand_bold' => 'Мятный насыщенный',
            'slate_wash' => 'Серо-голубой wash',
            'teal_mesh' => 'Сетка slate → teal',
            'warm_light' => 'Тёплый светлый',
            'quiz_panel' => 'Как блок квиза (бренд)',
            'plain_white' => 'Чисто белый',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function heroOptions(): array
    {
        return [
            'hero_default' => 'Как сейчас (бренд + радиус)',
            'hero_slate' => 'Светло-серый',
            'hero_brand_soft' => 'Мятный воздушный',
            'hero_brand_deep' => 'Мятный глубже',
            'hero_teal' => 'Teal + белый',
        ];
    }

    /** Фон секции (без отступов). */
    public static function sectionClasses(?string $preset): string
    {
        return match ($preset) {
            'brand_soft' => 'bg-gradient-to-br from-brand-100 via-brand-50 to-teal-50',
            'brand_bold' => 'bg-gradient-to-br from-brand-200 from-15% via-brand-100 to-white',
            'slate_wash' => 'bg-gradient-to-b from-slate-200 via-slate-100 to-white',
            'teal_mesh' => 'bg-gradient-to-br from-slate-200 via-teal-100 to-brand-100',
            'warm_light' => 'bg-gradient-to-br from-amber-100 via-orange-50 to-slate-50',
            'quiz_panel' => 'bg-gradient-to-br from-brand-100 via-cyan-50 to-white',
            'plain_white' => 'bg-white',
            default => 'bg-gradient-to-b from-brand-100 via-brand-50 to-slate-100',
        };
    }

    /** Базовый класс фона Hero (без overflow и т.д.). */
    public static function heroBaseClasses(?string $preset): string
    {
        return match ($preset) {
            'hero_slate' => 'bg-gradient-to-br from-slate-200 via-slate-100 to-white',
            'hero_brand_soft' => 'bg-gradient-to-br from-brand-100 via-brand-50 to-teal-100',
            'hero_brand_deep' => 'bg-gradient-to-br from-brand-200 from-10% via-brand-100 to-white',
            'hero_teal' => 'bg-gradient-to-br from-teal-100 via-brand-100 to-white',
            default => 'bg-gradient-to-br from-brand-100 via-teal-50 to-white',
        };
    }
}
