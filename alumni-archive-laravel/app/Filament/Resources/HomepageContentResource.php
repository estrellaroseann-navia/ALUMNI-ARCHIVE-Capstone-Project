<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\HomepageContent;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomepageContentResource\Pages;
use App\Filament\Resources\HomepageContentResource\RelationManagers;

class HomepageContentResource extends Resource
{
    protected static ?string $model = HomepageContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->label('Title')->required(),
                TextInput::make('description')->label('Description')->nullable(),
                FileUpload::make('src')
                    ->image()
                    ->label('Image')
                    ->directory('main-site-images')
                    ->preserveFilenames()
                    ->visibility('public')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->searchable(),
                TextColumn::make('description')->label('Description')->searchable()->limit(30),
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
            'index' => Pages\ListHomepageContents::route('/'),
            'create' => Pages\CreateHomepageContent::route('/create'),
            'edit' => Pages\EditHomepageContent::route('/{record}/edit'),
        ];
    }
}
