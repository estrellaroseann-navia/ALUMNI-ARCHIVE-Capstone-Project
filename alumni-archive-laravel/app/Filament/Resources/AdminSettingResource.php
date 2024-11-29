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
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdminSettingResource\Pages;
use App\Filament\Resources\AdminSettingResource\RelationManagers;

class AdminSettingResource extends Resource
{
    protected static ?string $navigationLabel = 'Manage Admins';
    protected static ?string $label = 'Admin';
    protected static ?string $slug = 'admins';

    public static function getNavigationGroup(): ?string
    {
        return 'Settings'; // Replace with your desired group name
    }


    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email'),
                TextColumn::make('name')->label('Username')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAdminSettings::route('/'),
            'create' => Pages\CreateAdminSetting::route('/create'),
            'edit' => Pages\EditAdminSetting::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('is_admin', 1)->whereNot('id', auth()->user()->id);
    }
}
