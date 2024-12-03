<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Manage Alumni';
    protected static ?string $label = 'Alumni';
    protected static ?string $slug = 'alumnis';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->schema([
                    Fieldset::make('profile')
                        ->relationship('profile')
                        ->label('Basic Information')
                        ->schema([
                            TextInput::make('first_name')->label('First Name')->required(),
                            TextInput::make('middle_name')->label('Middle Name')->nullable(),
                            TextInput::make('last_name')->label('Last Name')->required(),
                            Select::make('gender')
                                ->options([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                    'Other' => 'Other',
                                ]),
                            Select::make('employment_status')
                                ->options([
                                    'Employed' => 'Employed',
                                    'Unemployed' => 'Unemployed',
                                    'Untracked' => 'Untracked',
                                ])
                                ->label('Employment Status')
                                ->nullable(),
                            TextInput::make('employment_company')->label('Company Name')->required(),
                            Select::make('occupational_status')
                                ->options([
                                    'Govenrment' => 'Govenrment',
                                    'Private' => 'Private',
                                    'Other' => 'Other',
                                ])
                                ->label('Employment Status')
                                ->nullable(),
                            Select::make('employment_year')
                                ->label('Employment Year')
                                ->options(function () {
                                    $startYear = now()->year - 5; // 10 years back
                                    $endYear = now()->year;  // 10 years ahead
                                    return collect(range($startYear, $endYear))
                                        ->mapWithKeys(fn($year) => [$year => $year])
                                        ->toArray();
                                })
                                ->required(),
                            Textarea::make('complete_address')->label('Complete Address')->nullable(),
                            TextInput::make('city')->label('City')->nullable(),
                            TextInput::make('province')->label('Province')->nullable(),
                            TextInput::make('postal_code')->label('Postal Code')->nullable(),
                            TextInput::make('country')->label('Country')->nullable(),
                            Select::make('graduate_year')
                                ->label('Batch Year')
                                ->options(function () {
                                    $startYear = now()->year - 5; // 10 years back
                                    $endYear = now()->year;  // 10 years ahead
                                    return collect(range($startYear, $endYear))
                                        ->mapWithKeys(fn($year) => [$year => $year])
                                        ->toArray();
                                })
                                ->required(),
                            Fieldset::make('Program Name')->schema([
                                Select::make('program_id')
                                    ->relationship('program', 'name')
                                    ->label('Select Program')
                                    ->required(),
                            ]),
                            Fieldset::make('Campus')->schema([
                                Select::make('campus_id')
                                    ->relationship('campus', 'name')
                                    ->label('Select Campus')
                                    ->required(),
                            ]),
                        ])
                ]),

                Section::make('Documents')
                    ->description('To add an "Image" or "File" please press "Add to upload Supporting Documents" button')
                    ->schema([
                        Repeater::make('uploads')
                            ->label('Upload Supporting Documents')
                            ->relationship('uploads')
                            ->schema([
                                FileUpload::make('src')
                                    ->label('Document')
                                    ->directory('uploads')
                                    ->storeFileNamesIn('original_file_name')
                                    ->preserveFilenames()
                                    ->visibility('public')
                                    ->downloadable()
                            ])
                            ->columns(1)
                            ->collapsible()
                            ->nullable()
                            ->default([]) // Allow the repeater to be left empty
                        // Only save if there's an upload
                    ]),


                Section::make('Account Login Information')
                    ->headerActions([
                        Action::make('Account Activation')
                            ->label(fn($record) => $record->status ? 'Deactivate Account' : 'Activate Account') // Dynamic label
                            ->color(fn($record) => $record->status ? 'danger' : 'success') // Dynamic button color
                            ->action(function ($record) {
                                $record->status = !$record->status; // Toggle the `is_active` status
                                $record->save(); // Save the changes

                                Notification::make()
                                    ->title($record->status ? 'Account Activated' : 'Account Deactivated')
                                    ->success()
                                    ->send(); // Show a success notification
                            })
                            ->visible(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord), // Show only on edit
                        Action::make('Change Password')
                            ->modalHeading('Change Password')
                            ->modalWidth('sm')
                            ->form([
                                TextInput::make('new_password')
                                    ->label('New Password')
                                    ->password()
                                    ->rules(['required', 'string', 'min:8', 'confirmed'])
                                    ->required(),
                                TextInput::make('new_password_confirmation')
                                    ->label('Confirm Password')
                                    ->password()
                                    ->rules(['required', 'string'])
                                    ->required(),
                            ])
                            ->action(function ($data, $record) {
                                if ($data['new_password'] === $data['new_password_confirmation']) {
                                    $record->password = bcrypt($data['new_password']);
                                    $record->save();

                                    Notification::make()
                                        ->title('Password Updated Successfully')
                                        ->success()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('Passwords Do Not Match')
                                        ->danger()
                                        ->send();
                                }
                            })
                            ->visible(fn($livewire) => $livewire instanceof EditRecord),
                    ])
                    ->schema([
                        TextInput::make('name')->required()->label('Username'),
                        TextInput::make('email')->email()->required()->label('Email'),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                            ->required(fn($livewire) => $livewire instanceof CreateRecord)
                            ->rules(fn($livewire) => $livewire instanceof CreateRecord
                                ? ['required', 'string', 'min:8', 'confirmed']
                                : ['nullable', 'string', 'min:8', 'confirmed'])
                            ->dehydrated(fn($state) => filled($state))
                            ->visible(fn($livewire) => $livewire instanceof CreateRecord), // Visible only when creating
                        TextInput::make('password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required(fn($livewire) => $livewire instanceof CreateRecord)
                            ->dehydrated(false)
                            ->visible(fn($livewire) => $livewire instanceof CreateRecord),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profile.first_name')->label('First Name')->searchable(),
                TextColumn::make('profile.last_name')->label('Last Name')->searchable(),
                TextColumn::make('email')->label('Email'),
                IconColumn::make('profile.employment_status')->label('Employement Status')
                    ->icon(fn(string $state): string => match ($state) {
                        'Employed' => 'heroicon-o-check',
                        'Unemployed' => 'heroicon-o-x-mark',
                        'Untracked' => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Employed' => 'success',
                        'Unemployed' => 'danger',
                        'Untracked' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('profile.program.name')->label('Program')->searchable(),
                TextColumn::make('profile.graduate_year')->label('Batch')->searchable(),
                TextColumn::make('profile.campus.cluster.name')->label('Cluster')->searchable(),

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                SelectFilter::make('profile')
                    ->relationship('profile', 'graduate_year')
                    ->label('Batch Year')
                    ->options(function () {
                        $startYear = now()->year - 5; // 10 years back
                        $endYear = now()->year;  // 10 years ahead
                        return collect(range($startYear, $endYear))
                            ->mapWithKeys(fn($year) => [$year => $year])
                            ->toArray();
                    }),

                SelectFilter::make('program')
                    ->relationship('profile.program', 'name') // Relationship for filtering
                    ->label('Filter by Program')
                    ->placeholder('All Programs'),
                SelectFilter::make('campus')
                    ->relationship('profile.campus', 'name') // Relationship for filtering
                    ->label('Filter by Campus')
                    ->placeholder('All Campus'),
                SelectFilter::make('cluster')
                    ->relationship('profile.campus.cluster', 'name') // Relationship for filtering
                    ->label('Filter by Cluster')
                    ->placeholder('All Cluster'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function CanEditRecords(): bool
    {
        return false; // Prevent all users from editing
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('is_admin', 0);
    }
}
