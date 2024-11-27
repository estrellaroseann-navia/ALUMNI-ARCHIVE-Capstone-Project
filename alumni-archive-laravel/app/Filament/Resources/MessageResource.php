<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Message;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
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
