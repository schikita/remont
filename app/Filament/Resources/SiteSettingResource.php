<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Брендинг';

    protected static ?string $navigationGroup = 'Настройки';

    protected static ?int $navigationSort = 10;

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
            Forms\Components\TextInput::make('site_name')->required()->maxLength(255),
            Forms\Components\FileUpload::make('logo_path')
                ->label('Логотип')
                ->disk('public')
                ->directory('branding')
                ->visibility('public')
                ->image()
                ->imageEditor()
                ->nullable(),
            Forms\Components\FileUpload::make('favicon_path')
                ->label('Favicon')
                ->disk('public')
                ->directory('branding')
                ->visibility('public')
                ->nullable(),
            Forms\Components\TextInput::make('header_cta_label')->maxLength(120),
            Forms\Components\TextInput::make('header_messenger_label')->maxLength(120),
            Forms\Components\TextInput::make('footer_cta_label')->maxLength(120),
            Forms\Components\Textarea::make('footer_note')->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiteSettings::route('/'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
