<?php

declare(strict_types=1);

namespace App\Filament\Resources\DomainResource\RelationManagers;

use App\Models\Record;
use App\Services\AuditLogService;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class RecordRelationManager extends RelationManager
{
    protected static string $relationship = 'records';

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('record_type_id')
                ->relationship('recordType', 'name')
                ->required(),

            TextInput::make('url')
                ->required()
                ->url(),

            TextInput::make('username')->required(),

            TextInput::make('password')
                ->password()
                ->required()
                ->suffixAction(
                    fn(?string $state, Set $set): Action => Action::make('generate')
                        ->label('Generate')
                        ->button()
                        ->action(fn() => $set('password', Str::password(16))),
                )
                ->formatStateUsing(function ($state) {
                    if ($state) {
                        return Crypt::decryptString($state);
                    }
                    return null;
                })
                ->dehydrateStateUsing(fn($state) => Crypt::encryptString($state))
                ->dehydrated(fn($state) => filled($state)),

            TextInput::make('password_expiry_days')
                ->numeric()
                ->minValue(1)
                ->default(90)
                ->required()
                ->helperText('Number of days until password expires'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recordType.name'),
                TextColumn::make('url'),
                TextColumn::make('username')->copyable(),
                TextColumn::make('password')
                    ->copyable()
                    ->icon('heroicon-s-document-duplicate')
                    ->formatStateUsing(function (string $state, Record $record): string {
                        AuditLogService::log('view_password', $record);
                        return Crypt::decryptString($state);
                    }),
                TextColumn::make('password_status')
                    ->label('Password Status')
                    ->getStateUsing(function (Record $record) {
                        if ($record->isPasswordExpired()) {
                            return 'Expired';
                        }
                        if ($record->isPasswordNearingExpiry()) {
                            return 'Expires in ' . $record->daysUntilExpiry() . ' days';
                        }
                        return 'Valid';
                    })
                    ->badge()
                    ->color(function (Record $record) {
                        if ($record->isPasswordExpired()) {
                            return 'danger';
                        }
                        if ($record->isPasswordNearingExpiry()) {
                            return 'warning';
                        }
                        return 'success';
                    }),

                TextColumn::make('password_last_changed')
                    ->label('Last Changed')
                    ->date(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()->after(function (Record $record): void {
                    AuditLogService::log('create', $record);
                }),
            ])
            ->actions([
                EditAction::make()->before(function (Record $record): void {
                    AuditLogService::log('edit', $record);
                }),
                DeleteAction::make()->before(function (Record $record): void {
                    AuditLogService::log('delete', $record);
                }),
            ])
            ->recordAction(null)
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession()
            ->striped();
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
