<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\AuditLogResource\Pages\ListAuditLogs;
use App\Models\AuditLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static ?string $slug = 'audit-logs';

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 100;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                TextColumn::make('action')
                    ->badge()
                    ->color(
                        fn(string $state): string => match ($state) {
                            'view_password' => 'warning',
                            'create' => 'success',
                            'edit' => 'info',
                            'delete' => 'danger',
                            default => 'gray',
                        },
                    ),

                TextColumn::make('record.url')
                    ->label('Record URL')
                    ->searchable(),

                TextColumn::make('record.username')
                    ->label('Record Username')
                    ->searchable(),

                TextColumn::make('ip_address')->searchable(),

                TextColumn::make('user_agent')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        // Check if the state is longer than 30 characters (our limit)
                        if (mb_strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('action')->options([
                    'view_password' => 'View Password',
                    'create' => 'Create',
                    'edit' => 'Edit',
                    'delete' => 'Delete',
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuditLogs::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Audit Log');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Audit Logs');
    }
}
