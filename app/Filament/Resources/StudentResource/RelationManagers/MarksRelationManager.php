<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MarksRelationManager extends RelationManager
{
    protected static string $relationship = 'marks';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Forms\Components\Select::make('assessment_type')
                    ->options([
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                        'midterm' => 'Midterm',
                        'final' => 'Final',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('marks_obtained')
                    ->required()
                    ->numeric()
                    ->maxValue(100),
                Forms\Components\TextInput::make('total_marks')
                    ->required()
                    ->numeric()
                    ->maxValue(100),
                Forms\Components\TextInput::make('grade')
                    ->maxLength(255),
                Forms\Components\Textarea::make('remarks')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('course.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessment_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('marks_obtained')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade')
                    ->searchable(),
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 