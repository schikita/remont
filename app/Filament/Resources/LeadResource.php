<?php

namespace App\Filament\Resources;

use App\Enums\LeadStatus;
use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Заявки';

    protected static ?string $modelLabel = 'Заявка';

    protected static ?string $pluralModelLabel = 'Заявки';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Контакт')->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\Textarea::make('comment')->disabled()->rows(3),
                Forms\Components\TextInput::make('service_type')->disabled()->label('Услуга'),
                Forms\Components\TextInput::make('urgency')->disabled()->label('Срочность'),
                Forms\Components\TextInput::make('location')->disabled()->label('Адрес / район'),
                Forms\Components\TextInput::make('form_source')->disabled()->label('Источник формы'),
            ])->columns(2),
            Forms\Components\Section::make('UTM')->schema([
                Forms\Components\TextInput::make('utm_source')->disabled(),
                Forms\Components\TextInput::make('utm_medium')->disabled(),
                Forms\Components\TextInput::make('utm_campaign')->disabled(),
                Forms\Components\TextInput::make('utm_term')->disabled(),
                Forms\Components\TextInput::make('utm_content')->disabled(),
            ])->columns(3)->collapsed(),
            Forms\Components\Section::make('Обработка')->schema([
                Forms\Components\Select::make('status')
                    ->options(LeadStatus::class)
                    ->required(),
                Forms\Components\Textarea::make('manager_note')
                    ->label('Комментарий менеджера')
                    ->rows(4),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('form_source')->label('Форма')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('utm_source')->label('utm')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options(LeadStatus::class),
                Tables\Filters\Filter::make('utm')
                    ->form([
                        Forms\Components\TextInput::make('utm_source'),
                    ])
                    ->query(fn ($query, array $data) => $query->when(
                        $data['utm_source'] ?? null,
                        fn ($q, $v) => $q->where('utm_source', 'like', '%'.$v.'%'),
                    )),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
