<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Campus;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CampusResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CampusResource\RelationManagers;

class CampusResource extends Resource
{
    protected static ?string $model = Campus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return 'Campus Management'; // Replace with your desired group name
    }

    public static function getNavigationSort(): ?int
    {
        return 999; // Push this to the bottom
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Campus Name')->required(),
                TextInput::make('location'),
                TextInput::make('description'),
                Fieldset::make('Campus Name')->schema([
                    Select::make('cluster_id')
                        ->relationship('cluster', 'name')
                        ->label('Select Cluster')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Campus System ID'),
                TextColumn::make('name'),
                TextColumn::make('description')
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
            'index' => Pages\ListCampuses::route('/'),
            'create' => Pages\CreateCampus::route('/create'),
            'edit' => Pages\EditCampus::route('/{record}/edit'),
        ];
    }
}
