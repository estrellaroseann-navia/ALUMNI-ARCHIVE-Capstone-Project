<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Milestone;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MilestoneResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MilestoneResource\RelationManagers;

class MilestoneResource extends Resource
{
    protected static ?string $model = Milestone::class;



    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getNavigationGroup(): ?string
    {
        return 'Posts';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('src')
                    ->image()
                    ->label('Image')
                    ->directory('main-site-images')
                    ->preserveFilenames()
                    ->visibility('public'),
                TextInput::make('description')->label('Description')->nullable(),
                TextInput::make('link')->label('Link')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')->label('Description')->searchable()->limit(30),
                TextColumn::make('link')->label('Link')->searchable(),
                ImageColumn::make('src'),
                ToggleColumn::make('status')
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
            'index' => Pages\ListMilestones::route('/'),
            'create' => Pages\CreateMilestone::route('/create'),
            'edit' => Pages\EditMilestone::route('/{record}/edit'),
        ];
    }
}
