<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Услуги';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 32;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    if (filled($get('slug'))) {
                        return;
                    }
                    $set('slug', Str::slug((string) $state));
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('seo_page_slug')
                ->label('SEO-страница (slug)')
                ->maxLength(255)
                ->helperText('Slug из раздела «SEO-страницы», например remont-sanuzla-pod-klyuch-minsk. Пусто — ссылка в карточке ведёт только на форму заявки.'),
            Forms\Components\Textarea::make('short_description')->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('price_from')->label('Цена от')->maxLength(60),
            Forms\Components\TextInput::make('icon')->label('Иконка (emoji или короткий код)')->maxLength(32),
            Forms\Components\FileUpload::make('image_path')->disk('public')->directory('services')->image(),
            Forms\Components\TextInput::make('cta_label')->maxLength(80),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->label('Опубликовано'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('seo_page_slug')->label('SEO')->toggleable(),
                Tables\Columns\TextColumn::make('price_from'),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
