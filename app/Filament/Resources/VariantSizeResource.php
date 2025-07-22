<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VariantSizeResource\Pages;
use App\Filament\Resources\VariantSizeResource\RelationManagers;
use App\Models\VariantSize;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VariantSizeResource extends Resource
{
    protected static ?string $model = VariantSize::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Product Variant Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Variant Size Details')
                    ->schema([
                        Select::make('variant_id')
                            ->label('Variant')
                            ->relationship('variant', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('size_label')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->minValue(0)
                            ->maxValue(999999.99),
                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(999999),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('variant.name')
                    ->label('Variant')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('size_label')
                    ->label('Size Label')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),
                TextColumn::make('stock')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListVariantSizes::route('/'),
            'create' => Pages\CreateVariantSize::route('/create'),
            'edit' => Pages\EditVariantSize::route('/{record}/edit'),
        ];
    }
}
