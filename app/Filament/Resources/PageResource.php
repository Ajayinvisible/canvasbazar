<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Menu;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Create Page And Link Menu')->tabs([
                    Tab::make('Page')
                        ->icon('heroicon-o-computer-desktop')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            Select::make('menu_id')
                                ->label('Link Menu')
                                ->relationship('menu', 'name')
                                ->preload()
                                ->searchable()
                                ->required()
                                ->columnSpan(1),
                            TextInput::make('title')
                                ->required()
                                ->rules('string|max:160')
                                ->columnSpan(2),
                            RichEditor::make('description')->columnSpanFull(),
                            Toggle::make('status'),
                        ])->columns(3),
                    Tab::make('Meta Property')
                        ->icon('heroicon-o-cog')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            Textarea::make('meta_keywords')
                                ->label('Meta Keywords')
                                ->rules('string|max:200'),
                            Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rules('string|max:160'),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
