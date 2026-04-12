<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScriptSettingResource\Pages;
use App\Models\ScriptSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ScriptSettingResource extends Resource
{
    protected static ?string $model = ScriptSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $navigationLabel = 'Скрипты и аналитика';

    protected static ?string $navigationGroup = 'SEO и аналитика';

    protected static ?int $navigationSort = 21;

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
            Forms\Components\TextInput::make('google_analytics_id')->label('GA4 / gtag ID')->maxLength(64),
            Forms\Components\TextInput::make('google_tag_manager_id')->label('GTM ID')->maxLength(32),
            Forms\Components\TextInput::make('yandex_metrika_id')->label('Я.Метрика ID')->maxLength(32),
            Forms\Components\Textarea::make('head_scripts')->label('Скрипты в <head>')->rows(4),
            Forms\Components\Textarea::make('body_start_scripts')->label('После <body>')->rows(4),
            Forms\Components\Textarea::make('body_end_scripts')->label('Перед </body>')->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('google_analytics_id')->label('GA'),
                Tables\Columns\TextColumn::make('google_tag_manager_id')->label('GTM'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageScriptSettings::route('/'),
            'edit' => Pages\EditScriptSetting::route('/{record}/edit'),
        ];
    }
}
