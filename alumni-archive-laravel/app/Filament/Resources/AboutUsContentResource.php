<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AboutUsContent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AboutUsContentResource\Pages;
use App\Filament\Resources\AboutUsContentResource\RelationManagers;

class AboutUsContentResource extends Resource
{
    protected static ?string $model = AboutUsContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('mission_text')->label('Mission')->nullable(),
                FileUpload::make('mission_img')
                    ->image()
                    ->label('Image')
                    ->directory('main-site-images')
                    ->preserveFilenames()
                    ->visibility('public'),
                Textarea::make('vision_text')->label('Vision')->nullable(),
                FileUpload::make('vision_img')
                    ->image()
                    ->label('Image')
                    ->directory('main-site-images')
                    ->preserveFilenames()
                    ->visibility('public'),
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
                TextColumn::make('mission_text')->label('Mission')->limit(30),
                ImageColumn::make('mission_img'),
                TextColumn::make('vision_text')->label('Vision')->limit(30),
                ImageColumn::make('vision_img'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAboutUsContents::route('/'),
            'create' => Pages\CreateAboutUsContent::route('/create'),
            'edit' => Pages\EditAboutUsContent::route('/{record}/edit'),
        ];
    }
}
