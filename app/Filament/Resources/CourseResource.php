<?php

namespace App\Filament\Resources;

use App\Models\Course;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\CourseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CourseResource\RelationManagers;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Course Management';
    protected static ?string $navigationLabel = 'Courses';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('course_code')
                    ->required()
                    ->label('Course Code')
                    ->placeholder('Enter Course Code')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Title')
                    ->placeholder('Enter Title')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Description')
                    ->placeholder('Enter Description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('credits')
                    ->required()
                    ->label('Credits')
                    ->placeholder('Enter Credits')
                    ->numeric(),
                Forms\Components\TextInput::make('duration_weeks')
                    ->required()
                    ->label('Duration Weeks')
                    ->placeholder('Enter Duration Weeks')
                    ->numeric(),
                Forms\Components\TextInput::make('fee')
                    ->required()
                    ->label('Fee')
                    ->placeholder('Enter Fee')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('level')
                    ->label('Level')
                    ->placeholder('Select Level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('course_code')
                    ->label('Course Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('credits')
                    ->label('Credits')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_weeks')
                    ->label('Duration Weeks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fee')
                    ->label('Fee')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->label('Level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\EnrollmentsRelationManager::class,
            RelationManagers\AttendancesRelationManager::class,
            RelationManagers\MarksRelationManager::class,
            RelationManagers\InstructorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
} 