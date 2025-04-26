<?php

namespace App\Filament\Resources\InstructorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role')
                    ->options([
                        'primary' => 'Primary Instructor',
                        'secondary' => 'Secondary Instructor',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('course_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('credits')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_weeks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fee')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pivot.role')
                    ->label('Role')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
} 