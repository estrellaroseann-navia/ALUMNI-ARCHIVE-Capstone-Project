<?php

namespace App\Filament\Resources;

use App\Mail\Reply;
use Filament\Forms;
use Filament\Tables;
use App\Models\Message;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\MessageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MessageResource\RelationManagers;


class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function getNavigationBadge(): ?string
    {
        // Count messages where status = 0
        return (string) Message::where('status', 0)->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
                Textarea::make('message'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('message')->label('Message')->limit(32),
                CheckboxColumn::make('status')->label('Read'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->mutateRecordDataUsing(function (Message $record): array {
                    // Update the status to 1
                    $record->update(['status' => 1]);

                    // Return the updated record data (if needed for display purposes)
                    return $record->toArray();
                }),

                Tables\Actions\DeleteAction::make(),

                Action::make('reply')
                    ->label('Reply')
                    ->modalHeading('Reply to Message')
                    ->button('Send Reply') // Set the button text for the modal
                    ->form([
                        Textarea::make('reply')
                            ->label('Your Reply')
                            ->placeholder('Write your reply here...')
                            ->required(), // Make the reply field required
                    ])
                    ->action(function (Message $record, array $data) {
                        // Access the 'reply' value from the form data
                        $reply = $data['reply']; // This is the value entered in the Textarea

                        if (!empty($reply)) {
                            // Send the email with the reply content
                            Mail::to($record->email)->send(new Reply($reply));

                            // Send a success notification after the email is sent
                            Notification::make()
                                ->title('Reply Sent')
                                ->success()
                                ->send();
                        } else {
                            // Handle error if the reply is empty (fallback if validation fails)
                            Notification::make()
                                ->title('Reply is required')
                                ->danger()
                                ->send();
                        }
                    })



            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                BulkAction::make('status')
                    ->label('Mark as read')
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            $record->update(['status' => 1]); // Set status to 1
                        });
                    })
                    ->color('success'),
            ]);
    }

    protected function getActions(): array
    {
        return [
            Tables\Actions\ViewAction::make()
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Disable the "Create" action for this resource
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()
            ->orderBy('created_at', 'desc'); // Sort by latest
    }
}
