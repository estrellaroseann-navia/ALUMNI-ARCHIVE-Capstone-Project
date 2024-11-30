<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Colleges;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CollegesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CollegesResource\RelationManagers;
use Filament\Forms\Components\Textarea;

class CollegesResource extends Resource
{
    protected static ?string $model = Colleges::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationGroup(): ?string
    {
        return 'Academic Management'; // Replace with your desired group name
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('College Name')->required(),
                TextInput::make('description'),
                Section::make('Programs')
                    ->schema([
                        Repeater::make('programs')
                            ->relationship('programs')  // Assumes a relationship exists
                            ->schema([
                                TextInput::make('name')  // Program name
                                    ->label('Program Name')
                                    ->required(),

                                Textarea::make('description')  // Program description
                                    ->label('Program Description')
                                    ->required(),

                            ])
                            ->columns(1)
                            ->collapsible()
                            ->nullable()  // Allow the repeater to be left empty
                            ->default([])  // Allow the repeater to be left empty
                    ]),

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

    protected function afterCreate(): void
    {
        $this->redirect(CollegesResource::getUrl('index'));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListColleges::route('/'),
            'create' => Pages\CreateColleges::route('/create'),
            'edit' => Pages\EditColleges::route('/{record}/edit'),
        ];
    }
}
