<?php

namespace App\Filament\Resources\Assignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class AssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                
                \Filament\Tables\Columns\TextColumn::make('subject')
                    ->label('Matière')
                    ->badge(),
                
                \Filament\Tables\Columns\TextColumn::make('deadline')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable(),
                
                \Filament\Tables\Columns\TextColumn::make('priority')
                    ->label('Priorité')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'success',
                    }),
                
                \Filament\Tables\Columns\IconColumn::make('completed')
                    ->label('Terminé')
                    ->boolean(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('priority')
                    ->label('Priorité')
                    ->options([
                        'low' => 'Basse',
                        'medium' => 'Moyenne',
                        'high' => 'Haute',
                    ]),
                \Filament\Tables\Filters\TernaryFilter::make('completed')
                    ->label('Terminé'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
