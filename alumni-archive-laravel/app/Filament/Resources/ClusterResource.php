<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cluster;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ClusterResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClusterResource\RelationManagers;

class ClusterResource extends Resource
{
    protected static ?string $model = Cluster::class;

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
                TextInput::make('name')->label('Cluster Name')->required(),
                TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Id'),
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
            'index' => Pages\ListClusters::route('/'),
            'create' => Pages\CreateCluster::route('/create'),
            'edit' => Pages\EditCluster::route('/{record}/edit'),
        ];
    }
}
