<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeoPageResource\Pages;
use App\Models\SeoPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SeoPageResource extends Resource
{
    protected static ?string $model = SeoPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'SEO-страницы';

    protected static ?string $modelLabel = 'SEO-страница';

    protected static ?string $pluralModelLabel = 'SEO-страницы';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('h1')
                ->label('Заголовок H1')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    if (blank($get('meta_title'))) {
                        $set('meta_title', $state);
                    }
                }),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('URL: /uslugi/{slug}. Латиница, дефисы.'),
            Forms\Components\TextInput::make('meta_title')
                ->label('Meta title')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('meta_description')
                ->label('Meta description')
                ->rows(3)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('intro')
                ->label('Лид под H1')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('content')
                ->label('Контент (HTML)')
                ->required()
                ->rows(18)
                ->columnSpanFull()
                ->helperText('Допускаются теги HTML (заголовки, списки, ссылки).'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->label('Опубликовано')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('h1')->limit(40)->searchable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSeoPages::route('/'),
            'create' => Pages\CreateSeoPage::route('/create'),
            'edit' => Pages\EditSeoPage::route('/{record}/edit'),
        ];
    }
}
