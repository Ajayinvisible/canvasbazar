<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeBannerResource\Pages;
use App\Filament\Resources\HomeBannerResource\RelationManagers;
use App\Models\HomeBanner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeBannerResource extends Resource
{
    protected static ?string $model = HomeBanner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Home Page Features';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Home Banner')
                    ->description('Home Page Category Ways Banner')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->rules('string|max:70'),
                        Select::make('banner_for')
                            ->label('Banner For')
                            ->options([
                                'trending' => 'Trending',
                                'featured' => 'Featured',
                                'shop-canvas' => 'Shop Canvas',
                                'custom-canvas' => 'Custom Canvas',
                                'gift-idea' => 'Gift Idea',
                                'corporate-order' => 'Corporate order'
                            ]),
                        FileUpload::make('image')
                            ->rules('image|mimes:png,jpg,jpeg,gif|max:2048')
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('status'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('image'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('banner_for')->sortable()->searchable(),
                ToggleColumn::make('status')->sortable(),
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
            'index' => Pages\ListHomeBanners::route('/'),
            'create' => Pages\CreateHomeBanner::route('/create'),
            'edit' => Pages\EditHomeBanner::route('/{record}/edit'),
        ];
    }
}
