<?php

declare(strict_types = 1);

namespace App\Filament\Resources;

use App\Filament\Resources\RecordResource\Pages;
use App\Models\Record;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecordResource extends Resource
{

    protected static ?string $model = Record::class;

    protected static ?string $slug = 'records';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('record_type_id')
                    ->relationship('recordType', 'name')
                    ->required(),

                TextInput::make('url')
                    ->required()
                    ->url(),

                TextInput::make('username')
                    ->required(),

                TextInput::make('password')
                    ->required()
                    ->suffixAction(fn (?string $state, Set $set): Action =>
                    Action::make('generate')
                        ->label('Generate')
                        ->visible(fn () => ! $state)
                        ->button()
                        ->action(fn() => $set('password', Str::password(16))),
                    ),

                Select::make('domain_id')
                    ->relationship('domain', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('recordType.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('url')
                    ->icon('heroicon-c-link')
                    ->html()
                    ->getStateUsing(fn ($record) => '<a href="' . $record->url . '" target="_blank" rel="noopener noreferrer">' . $record->url . '</a>'),

                TextColumn::make('username')->copyable()->icon('heroicon-s-document-duplicate'),

                TextColumn::make('password')->copyable()->icon('heroicon-s-document-duplicate'),

                TextColumn::make('domain.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordAction(null)
            ->recordUrl(null);
    }

    public static function getPages(): array
    {

        return [
            'index' => Pages\ListRecords::route('/'),
            //'create' => Pages\CreateRecord::route('/create'),
            //'edit'   => Pages\EditRecord::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {

        return parent::getGlobalSearchEloquentQuery()->with(['recordType', 'domain']);
    }

    public static function getGloballySearchableAttributes(): array
    {

        return ['recordType.name', 'domain.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {

        $details = [];

        if ($record->recordType) {
            $details['RecordType'] = $record->recordType->name;
        }

        if ($record->domain) {
            $details['Domain'] = $record->domain->name;
        }

        return $details;
    }

    public static function getNavigationBadge(): ?string
    {

        return (string)(static::getModel()::count());
    }

    public static function getModelLabel(): string
    {

        return __('Record');
    }

    public static function getPluralModelLabel(): string
    {

        return __('Records');
    }

}
