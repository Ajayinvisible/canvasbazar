<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariantResource\Pages;
use App\Filament\Resources\VariantResource\RelationManagers;
use App\Models\Variant;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantResource extends Resource
{
    protected static ?string $model = Variant::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationGroup = 'Product Variant Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Variant Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Variant Name'),
                        Textarea::make('description')
                            ->nullable()
                            ->maxLength(500),
                        Toggle::make('status')
                            ->default(true)
                            ->label('Active Status'),
                        Toggle::make('is_custom')
                            ->default(false)
                            ->label('Is Custom Variant'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Variant Name'),
                TextColumn::make('description')
                    ->limit(50)
                    ->label('Description'),
                ToggleColumn::make('status')
                    ->sortable(),
                ToggleColumn::make('is_custom')
                    ->label('Custom Variant')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVariants::route('/'),
            'create' => Pages\CreateVariant::route('/create'),
            'edit' => Pages\EditVariant::route('/{record}/edit'),
        ];
    }
}
