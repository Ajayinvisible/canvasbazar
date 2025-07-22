<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Creat Category And Sub-Category')->tabs([
                    Tab::make('Category')
                        ->icon('heroicon-o-tag')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            Section::make('Category Info')
                                ->description('Create category and sub-category')
                                ->schema([
                                    Select::make('parent_id')
                                        ->label('Parent Category')
                                        ->options(self::getNestedCategoryOptions())
                                        ->nullable(),

                                    Grid::make(2)->schema([
                                        TextInput::make('name')
                                            ->live(onBlur: true)
                                            ->required()
                                            ->rules('string|max:60')
                                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) {
                                                if ($operation == 'edit') {
                                                    return;
                                                }
                                                $set('slug', Str::slug($state));
                                            }),

                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                    ]),

                                    RichEditor::make('short_intro')
                                        ->nullable()
                                ])->columnSpan(2),
                            Section::make('Category Icon')
                                ->description('Category Icon or Image')
                                ->schema([
                                    FileUpload::make('image')
                                        ->rules('image|mimes:png,jpg,jpeg,gif|max:150')
                                        ->nullable(),
                                    Toggle::make('status')
                                ])->columnSpan(1)
                        ])->columns(3),
                    Tab::make('Category Information')
                        ->icon('heroicon-o-information-circle')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            Section::make('Category Information')
                                ->description('Category detail information and meta properties')
                                ->schema([
                                    Textarea::make('meta_keywords')
                                        ->label('Meta Keywords')
                                        ->rules('string|max:255')
                                        ->nullable(),
                                    Textarea::make('meta_description')
                                        ->label('Meta Description')
                                        ->rules('string|max:160')
                                        ->nullable(),
                                    RichEditor::make('description')
                                        ->nullable()
                                ])
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable(),
                ImageColumn::make('image'),
                TextColumn::make('indented_name') // Replaces raw name
                    ->label('Name')
                    ->sortable(query: fn($query, $direction) => $query->orderBy('name', $direction))
                    ->searchable(),
                TextColumn::make('slug')->searchable()->sortable(),
                TextColumn::make('indented_parent_name') // Replaces parent.name
                    ->label('Parent Category')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('status')->sortable()
            ])
            ->filters([
                TernaryFilter::make('status'),
                SelectFilter::make('parent.id')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNestedCategoryOptions($parentId = null, $prefix = ''): array
    {
        $categories = Category::where('parent_id', $parentId)->get();

        $options = [];

        foreach ($categories as $category) {
            $options[$category->id] = $prefix . $category->name;
            $children = self::getNestedCategoryOptions($category->id, $prefix . '- ');
            $options += $children;
        }

        return $options;
    }
}
