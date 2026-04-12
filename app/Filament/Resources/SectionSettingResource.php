<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionSettingResource\Pages;
use App\Models\SectionSetting;
use App\Support\SectionGradient;
use App\Support\SectionKey;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SectionSettingResource extends Resource
{
    protected static ?string $model = SectionSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Секции лендинга';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 39;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('section_key')->disabled(),
            Forms\Components\Toggle::make('is_enabled')->label('Включено'),
            Forms\Components\Select::make('gradient_preset')
                ->label('Фон секции (градиент)')
                ->options(SectionGradient::sectionOptions())
                ->native(false)
                ->nullable()
                ->helperText('Только фон блока; отступы и рамки задаются в вёрстке секции.'),
            Forms\Components\TextInput::make('sort_order')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('section_key')->label('Секция')->formatStateUsing(fn ($state) => self::labelFor($state)),
                Tables\Columns\IconColumn::make('is_enabled')->label('Вкл.')->boolean(),
                Tables\Columns\TextColumn::make('gradient_preset')->label('Фон')->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSectionSettings::route('/'),
            'edit' => Pages\EditSectionSetting::route('/{record}/edit'),
        ];
    }

    public static function labelFor(string $key): string
    {
        return match ($key) {
            SectionKey::Hero => 'Hero',
            SectionKey::Services => 'Услуги',
            SectionKey::Advantages => 'Преимущества',
            SectionKey::HowWeWork => 'Как работаем',
            SectionKey::Quiz => 'Квиз',
            SectionKey::Gallery => 'Галерея',
            SectionKey::Reviews => 'Отзывы',
            SectionKey::Faq => 'FAQ',
            SectionKey::About => 'О компании',
            SectionKey::Contacts => 'Контакты',
            default => $key,
        };
    }
}
