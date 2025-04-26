<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->required(),
                Forms\Components\DatePicker::make('enrollment_date')
                    ->required(),
                Forms\Components\DatePicker::make('completion_date'),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'dropped' => 'Dropped',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('grade')
                    ->numeric()
                    ->maxValue(100),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('student.first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.last_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrollment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completion_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade')
                    ->numeric()
                    ->sortable(),
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