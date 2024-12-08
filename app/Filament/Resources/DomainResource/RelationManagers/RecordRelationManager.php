<?php

namespace App\Filament\Resources\DomainResource\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RecordRelationManager extends RelationManager
{

    protected static string $relationship = 'records';

    public function form(Form $form): Form
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
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recordType.name'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('password'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
