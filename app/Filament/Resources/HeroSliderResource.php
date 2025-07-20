<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSliderResource\Pages;
use App\Filament\Resources\HeroSliderResource\RelationManagers;
use App\Models\HeroSlider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
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

class HeroSliderResource extends Resource
{
    protected static ?string $model = HeroSlider::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Home Page Features';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Slider')
                    ->description('Home Page Hero Slider Details')
                    ->schema([
                        TextInput::make('title_blue')
                            ->label('Title Blue')
                            ->required()
                            ->rules('string|max:60'),
                        TextInput::make('title_black')
                            ->label('Title Blue')
                            ->required()
                            ->rules('string|max:60'),
                        Textarea::make('text')
                            ->label('Short Description')
                            ->rules('max:160')
                            ->columnSpanFull(),
                        TextInput::make('button_text')
                            ->rules('max:15'),
                        TextInput::make('button_link')
                            ->label('Product Link')
                            ->rules('url')
                            ->required(),
                    ])->columns(2)
                    ->columnSpan(2),
                Section::make('Hero Slider Image')
                    ->description('Home Page Hero Slider Image Upload Here')
                    ->schema([
                        FileUpload::make('image')
                            ->required()
                            ->rules('image|mimes:png,jpg,jpeg,gif|max:2048'),
                        TextInput::make('order_by')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),
                        Toggle::make('status')
                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('image')->sortable(),
                TextColumn::make('title_blue')->sortable()->searchable(),
                TextColumn::make('title_black')->sortable()->searchable(),
                ToggleColumn::make('status')->sortable()
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
            'index' => Pages\ListHeroSliders::route('/'),
            'create' => Pages\CreateHeroSlider::route('/create'),
            'edit' => Pages\EditHeroSlider::route('/{record}/edit'),
        ];
    }
}
