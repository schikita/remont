<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSettingResource\Pages;
use App\Models\ContactSetting;
use App\Rules\ViberOrHttpUrl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSettingResource extends Resource
{
    protected static ?string $model = ContactSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Контакты';

    protected static ?string $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 11;

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
            Forms\Components\TextInput::make('phone')
                ->tel()
                // Filament default tel regex rejects «+375 (33) 603-27-70» (скобки после пробела).
                ->telRegex('/^($|\+?[0-9][\d\s\(\)\-\.\/]{6,}[0-9])$/u')
                ->maxLength(50),
            Forms\Components\TextInput::make('email')->email()->maxLength(255),
            Forms\Components\TextInput::make('address')->maxLength(255),
            Forms\Components\Textarea::make('work_schedule')->rows(4),
            Forms\Components\TextInput::make('telegram_url')->url()->maxLength(255),
            Forms\Components\TextInput::make('whatsapp_url')->url()->maxLength(255),
            Forms\Components\TextInput::make('viber_url')
                ->maxLength(255)
                ->helperText('Допустимо viber://… или обычный https://…')
                ->rules([new ViberOrHttpUrl]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone')->label('Телефон'),
                Tables\Columns\TextColumn::make('email'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContactSettings::route('/'),
            'edit' => Pages\EditContactSetting::route('/{record}/edit'),
        ];
    }
}
