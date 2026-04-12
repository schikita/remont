<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoSettingResource\Pages;
use App\Models\SeoSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoSettingResource extends Resource
{
    protected static ?string $model = SeoSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'SEO главной';

    protected static ?string $navigationGroup = 'SEO и аналитика';

    protected static ?int $navigationSort = 20;

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
            Forms\Components\Section::make('Meta')->schema([
                Forms\Components\TextInput::make('meta_title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->rows(3),
                Forms\Components\TextInput::make('canonical_url')->url()->maxLength(255),
                Forms\Components\TextInput::make('robots')->maxLength(120),
            ]),
            Forms\Components\Section::make('Open Graph')->schema([
                Forms\Components\TextInput::make('og_title')->maxLength(255),
                Forms\Components\Textarea::make('og_description')->rows(3),
                Forms\Components\FileUpload::make('og_image_path')->label('OG изображение')->disk('public')->directory('seo')->image(),
                Forms\Components\TextInput::make('og_type')->maxLength(60),
            ])->collapsed(),
            Forms\Components\Section::make('Twitter')->schema([
                Forms\Components\TextInput::make('twitter_card')->maxLength(60),
                Forms\Components\TextInput::make('twitter_title')->maxLength(255),
                Forms\Components\Textarea::make('twitter_description')->rows(3),
                Forms\Components\FileUpload::make('twitter_image_path')->label('Twitter изображение')->disk('public')->directory('seo')->image(),
            ])->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('meta_title')->label('Title'),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSeoSettings::route('/'),
            'edit' => Pages\EditSeoSetting::route('/{record}/edit'),
        ];
    }
}
