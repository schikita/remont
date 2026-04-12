<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyPageResource\Pages;
use App\Models\PolicyPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PolicyPageResource extends Resource
{
    protected static ?string $model = PolicyPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Юридические страницы';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 38;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')->required()->maxLength(120)->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('title')->required()->maxLength(255),
            Forms\Components\RichEditor::make('content')->required()->columnSpanFull(),
            Forms\Components\Toggle::make('is_published')->label('Опубликовано'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePolicyPages::route('/'),
            'create' => Pages\CreatePolicyPage::route('/create'),
            'edit' => Pages\EditPolicyPage::route('/{record}/edit'),
        ];
    }
}
