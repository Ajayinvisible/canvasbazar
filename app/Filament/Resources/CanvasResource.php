<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CanvasResource\Pages;
use App\Filament\Resources\CanvasResource\RelationManagers;
use App\Models\Canvas;
use App\Models\Variant;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CanvasResource extends Resource
{
    protected static ?string $model = Canvas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    protected static ?string $navigationGroup = 'Product Variant Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Canvas Details')
                    ->schema([
                        Select::make('variant_id')
                            ->label('Variant')
                            ->options(Variant::where('is_custom', true)->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('type')
                            ->options([
                                'landscape' => 'Landscape',
                                'portrait' => 'Portrait',
                            ])
                            ->default('landscape')
                            ->label('Canvas Type')
                            ->required(),
                        FileUpload::make('canvas')
                            ->label('Canvas Image')
                            ->rules('image|mimes:png,jpg,jpeg|max:2048')
                            ->image()
                            ->required()
                            ->columnSpanFull()
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('variant.name')
                    ->label('Variant')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Canvas Type')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('canvas')
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
            'index' => Pages\ListCanvases::route('/'),
            'create' => Pages\CreateCanvas::route('/create'),
            'edit' => Pages\EditCanvas::route('/{record}/edit'),
        ];
    }
}
