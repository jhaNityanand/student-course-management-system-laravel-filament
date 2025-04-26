<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarkResource\Pages;
use App\Models\Mark;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarkResource extends Resource
{
    protected static ?string $model = Mark::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = 'Academic';
    protected static ?string $navigationLabel = 'Marks';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('assessment_type')
                    ->options([
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                        'midterm' => 'Midterm',
                        'final' => 'Final',
                        'project' => 'Project',
                        'lab' => 'Lab',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('marks_obtained')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('total_marks')
                    ->default(100)
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('grade')
                    ->maxLength(2),
                Forms\Components\Textarea::make('remarks')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('student.first_name')
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('assessment_type')
                    ->options([
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                        'midterm' => 'Midterm',
                        'final' => 'Final',
                        'project' => 'Project',
                        'lab' => 'Lab',
                    ]),
                Tables\Filters\SelectFilter::make('course')
                    ->relationship('course', 'title'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarks::route('/'),
            'create' => Pages\CreateMark::route('/create'),
            'edit' => Pages\EditMark::route('/{record}/edit'),
        ];
    }
} 