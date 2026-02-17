<?php

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Schemas\Schema;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Titre du devoir')
                    ->required()
                    ->maxLength(255),
                
                \Filament\Forms\Components\Select::make('subject')
                    ->label('Matière')
                    ->options([
                        'Mathématiques' => 'Mathématiques',
                        'Physique' => 'Physique',
                        'Informatique' => 'Informatique',
                        'Français' => 'Français',
                        'Anglais' => 'Anglais',
                        'Histoire' => 'Histoire',
                        'Autre' => 'Autre',
                    ])
                    ->required(),
                
                \Filament\Forms\Components\DatePicker::make('deadline')
                    ->label('Date limite')
                    ->required()
                    ->minDate(now()),
                
                \Filament\Forms\Components\Select::make('priority')
                    ->label('Priorité')
                    ->options([
                        'low' => 'Basse',
                        'medium' => 'Moyenne',
                        'high' => 'Haute',
                    ])
                    ->default('medium')
                    ->required(),
                
                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3),
                
                \Filament\Forms\Components\Toggle::make('completed')
                    ->label('Terminé')
                    ->default(false),
            ]);
    }
}
