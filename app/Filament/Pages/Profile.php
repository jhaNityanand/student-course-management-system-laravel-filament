<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use App\Models\UserDetail;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Validation\Rules\Password;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Actions\Action;

class Profile extends BaseEditProfile
{
    protected static ?string $model = User::class;
    protected static string $view = 'filament.pages.profile';

    public function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->action(function (array $data) {
                    $user = auth()->user();
                    
                    // Update User model
                    $user->name = $data['name'];
                    $user->email = $data['email'];
                    if (isset($data['new_password']) && !empty($data['new_password'])) {
                        $user->password = Hash::make($data['new_password']);
                    }
                    $user->save();

                    // Update or create UserDetail
                    $userDetail = UserDetail::updateOrCreate(
                        ['user_id' => $user->id],
                        [
                            'phone' => $data['phone'] ?? null,
                            'bio' => $data['bio'] ?? null,
                            'date_of_birth' => $data['date_of_birth'] ?? null,
                            'gender' => $data['gender'] ?? null,
                            'photo' => $data['userDetail']['photo'] ?? null,
                            'address_line1' => $data['userDetail']['address_line1'] ?? null,
                            'address_line2' => $data['userDetail']['address_line2'] ?? null,
                            'city' => $data['city'] ?? null,
                            'state' => $data['state'] ?? null,
                            'postal_code' => $data['postal_code'] ?? null,
                            'country' => $data['userDetail']['country'] ?? null,
                        ]
                    );

                    Notification::make()
                        ->success()
                        ->title('Profile updated successfully')
                        ->send();
                })
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        // Left Column - Profile Picture
                        Section::make('Profile Picture')
                            ->description('Update your profile picture')
                            ->schema([
                                FileUpload::make('userDetail.photo')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('profile_photos')
                                    ->avatar()
                                    ->imagePreviewHeight('250')
                                    ->panelAspectRatio('1:1')
                                    ->panelLayout('integrated')
                                    ->uploadProgressIndicatorPosition('center')
                                    ->circleCropper()
                                    ->helperText('Upload a clear photo of yourself. Recommended size: 200x200 pixels.')
                                    ->columnSpanFull()
                            ])
                            ->collapsible()
                            ->columnSpan(['xl' => 1]),

                        // Right Column - User Information
                        Section::make('Personal Information')
                            ->description('Update your personal information')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Full Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter your full name'),
                                        TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter your email'),
                                        TextInput::make('userDetail.phone')
                                            ->tel()
                                            ->maxLength(20)
                                            ->placeholder('Enter your phone number'),
                                        Select::make('userDetail.gender')
                                            ->options([
                                                'male' => 'Male',
                                                'female' => 'Female',
                                                'other' => 'Other',
                                            ])
                                            ->native(false)
                                            ->searchable(false)
                                            ->placeholder('Select your gender'),
                                        DatePicker::make('userDetail.date_of_birth')
                                            ->maxDate(now())
                                            ->placeholder('Select your date of birth'),
                                    ]),
                                Textarea::make('userDetail.bio')
                                    ->label('About Me')
                                    ->placeholder('Write a brief description about yourself')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->columnSpan(['lg' => 2]),

                        Section::make('Address Information')
                            ->description('Update your contact address')
                            ->collapsed()
                            ->schema([
                                TextInput::make('userDetail.address_line1')
                                    ->label('Address Line 1')
                                    ->maxLength(255)
                                    ->placeholder('Enter your street address'),
                                TextInput::make('userDetail.address_line2')
                                    ->label('Address Line 2')
                                    ->maxLength(255)
                                    ->placeholder('Apartment, suite, unit, etc.'),
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('userDetail.city')
                                            ->maxLength(100)
                                            ->placeholder('City'),
                                        TextInput::make('userDetail.state')
                                            ->maxLength(100)
                                            ->placeholder('State/Province'),
                                        TextInput::make('userDetail.postal_code')
                                            ->maxLength(20)
                                            ->placeholder('Postal/ZIP code'),
                                    ]),
                                Select::make('userDetail.country')
                                    ->options([
                                        'US' => 'United States',
                                        'CA' => 'Canada',
                                        'GB' => 'United Kingdom',
                                        'AU' => 'Australia',
                                        'IN' => 'India',
                                        // Add more countries as needed
                                    ])
                                    ->searchable()
                                    ->placeholder('Select country'),
                            ])
                            ->collapsible()
                            ->columnSpan(['lg' => 3]),

                        Section::make('Security')
                            ->description('Update your password')
                            ->collapsed()
                            ->schema([
                                TextInput::make('current_password')
                                    ->password()
                                    ->currentPassword()
                                    ->autocomplete('current-password')
                                    ->columnSpanFull(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('new_password')
                                            ->password()
                                            ->rule(Password::default())
                                            ->autocomplete('new-password')
                                            ->placeholder('Enter new password'),
                                        TextInput::make('new_password_confirmation')
                                            ->password()
                                            ->same('new_password')
                                            ->autocomplete('new-password')
                                            ->placeholder('Confirm new password'),
                                    ]),
                            ])
                            ->collapsible()
                            ->columnSpan(['lg' => 3]),
                    ])
                    ->columns(['lg' => 3]),
            ]);
    }
}
