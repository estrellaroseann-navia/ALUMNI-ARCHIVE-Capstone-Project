<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccountSettingResource\Pages;
use App\Filament\Resources\AccountSettingResource\RelationManagers;
use Filament\Forms\Components\Actions\Action;

class AccountSettingResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Account Setting';
    protected static ?string $label = 'My Account';
    protected static ?string $slug = 'my-account';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getNavigationGroup(): ?string
    {
        return 'Settings'; // Replace with your desired group name
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        Hidden::make('is_admin')
                            ->default(1)->nullable(),
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

    public static function canCreate(): bool
    {
        return self::getModel()::count() === 0;
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email'),
                TextColumn::make('name')->label('Username'),
            ])
            ->filters([
                //
            ])
            ->paginated(false) // This will hide pagination controls
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAccountSettings::route('/'),
            'create' => Pages\CreateAccountSetting::route('/create'),
            'edit' => Pages\EditAccountSetting::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('id', auth()->id());
    }
}
