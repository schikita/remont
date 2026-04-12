<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use App\Support\SectionGradient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Hero';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 30;

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
            Forms\Components\FileUpload::make('background_image_path')
                ->label('Фото примера (фон Hero)')
                ->disk('public')
                ->directory('hero')
                ->image()
                ->imageEditor()
                ->helperText('Необязательно. Показывается за лёгкой подложкой; для читаемости текста используйте светлые или широкие кадры.'),
            Forms\Components\Select::make('gradient_preset')
                ->label('Градиент Hero')
                ->options(SectionGradient::heroOptions())
                ->native(false)
                ->nullable(),
            Forms\Components\TextInput::make('headline')->required()->maxLength(255),
            Forms\Components\TextInput::make('subheadline')->maxLength(255),
            Forms\Components\Textarea::make('offer_text')->rows(3),
            Forms\Components\Textarea::make('trust_badges_text')
                ->label('Доверительные пункты (по одному в строке)')
                ->rows(4)
                ->afterStateHydrated(function (Forms\Components\Textarea $component, $state, $record) {
                    if ($record && is_array($record->trust_badges)) {
                        $component->state(implode("\n", $record->trust_badges));
                    }
                }),
            Forms\Components\TextInput::make('urgency_label')->maxLength(120),
            Forms\Components\TextInput::make('guarantee_label')->maxLength(120),
            Forms\Components\Toggle::make('show_lead_form')->label('Показывать форму в Hero'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('background_image_path')->disk('public')->height(40)->label('Фон'),
                Tables\Columns\TextColumn::make('headline'),
                Tables\Columns\TextColumn::make('gradient_preset')->label('Градиент')->toggleable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageHeroSections::route('/'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}
