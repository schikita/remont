<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'О компании';

    protected static ?string $navigationGroup = 'Контент';

    protected static ?int $navigationSort = 31;

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
            Forms\Components\TextInput::make('title')->required()->maxLength(255),
            Forms\Components\TextInput::make('subtitle')->maxLength(255),
            Forms\Components\RichEditor::make('body')->required()->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')->disk('public')->directory('about')->image(),
            Forms\Components\KeyValue::make('stats')->label('Цифры / факты')->keyLabel('Подпись')->valueLabel('Значение'),
            Forms\Components\Toggle::make('is_published')->label('Опубликовано'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAboutSections::route('/'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}
