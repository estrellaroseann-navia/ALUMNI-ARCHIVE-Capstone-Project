<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DonationContent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DonationContentResource\Pages;
use App\Filament\Resources\DonationContentResource\RelationManagers;

class DonationContentResource extends Resource
{
    protected static ?string $model = DonationContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Content Management';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('content')->label('Content')->nullable(),
                FileUpload::make('src')
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
                TextColumn::make('content')->label('Content')->limit(30),
                ImageColumn::make('src'),
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
            'index' => Pages\ListDonationContents::route('/'),
            'create' => Pages\CreateDonationContent::route('/create'),
            'edit' => Pages\EditDonationContent::route('/{record}/edit'),
        ];
    }
}
