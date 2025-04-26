<?php

namespace App\Filament\Resources;

use App\Models\Instructor;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use App\Filament\Resources\InstructorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InstructorResource\RelationManagers;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Instructor Management';
    protected static ?string $navigationLabel = 'Instructors';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('instructor_id')
                    ->required()
                    ->label('Instructor ID')
                    ->placeholder('Enter Instructor ID')
                    ->default(function () {
                        return 'INS-' . str_pad(Instructor::count() + 1, 4, '0', STR_PAD_LEFT);
                    })
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->label('First Name')
                    ->placeholder('Enter First Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->label('Last Name')
                    ->placeholder('Enter Last Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('Email')
                    ->placeholder('Enter Email')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qualification')
                    ->required()
                    ->label('Qualification')
                    ->placeholder('Enter Qualification')
                    ->maxLength(255),
                Forms\Components\TextInput::make('specialization')
                    ->required()
                    ->label('Specialization')
                    ->placeholder('Enter Specialization')
                    ->maxLength(255),
                Forms\Components\TextInput::make('years_of_experience')
                    ->required()
                    ->label('Years of Experience')
                    ->placeholder('Enter Years of Experience')
                    ->numeric(),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->imageEditor()
                    ->maxSize(1024 * 1) // 1MB
                    ->disk('instructors'),
                Forms\Components\Textarea::make('bio')
                    ->maxLength(65535)
                    ->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('instructor_id')
                    ->label('Instructor ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qualification')
                    ->label('Qualification')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specialization')
                    ->label('Specialization')
                    ->searchable(),
                Tables\Columns\TextColumn::make('years_of_experience')
                    ->label('Years of Experience')
                    ->numeric()
                    ->sortable(),
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
            RelationManagers\CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
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