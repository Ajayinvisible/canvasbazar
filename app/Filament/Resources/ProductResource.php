<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\VariantsRelationManager;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
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
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Product Details')
                    ->tabs([
                        Tab::make('Product Information')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Basic Information')
                                    ->description('Enter the basic details of the product.')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Product Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, string $state, Forms\Set $set) {
                                                if ($operation == 'edit') {
                                                    return;
                                                }
                                                $set('slug', Str::slug($state));
                                            })
                                            ->columnSpanFull(),

                                        Select::make('category_id')
                                            ->label('Category')
                                            ->options(self::getNestedCategoryOptions())
                                            ->required()
                                            ->searchable()
                                            ->preload(),

                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->readOnly(),
                                        RichEditor::make('short_intro')
                                            ->label('Short Introduction')
                                            ->columnSpanFull(),
                                        Toggle::make('status')
                                            ->label('Active')
                                            ->default(true)
                                    ])->columnSpan(2)->columns(2),
                                Group::make([
                                    Section::make('Product Thumbnail')
                                        ->description('Upload a thumbnail image for the product.')
                                        ->schema([
                                            FileUpload::make('thumbnail')
                                                ->label('Thumbnail')
                                                ->image()
                                                ->required()
                                                ->maxSize(2048)
                                                ->rules('mimes:png,jpg,jpeg,gif')
                                                ->columnSpanFull(),
                                        ])->columnSpan(1),
                                    Section::make('Product to featured or trending')
                                        ->description('Mark the product as featured or trending.')
                                        ->schema([
                                            Toggle::make('is_featured')
                                                ->label('Featured')
                                                ->default(false),
                                            Toggle::make('is_tranding')
                                                ->label('Trending')
                                                ->default(false),
                                            Toggle::make('is_custom')
                                                ->label('Custom Product')
                                                ->default(false),
                                        ])->columnSpanFull()
                                ])

                            ])->columns(3),
                        Tab::make('SEO and Description')
                            ->icon('heroicon-o-document-magnifying-glass')
                            ->schema([
                                Section::make('SEO & Description')
                                    ->description('Enter SEO details and product description.')
                                    ->schema([
                                        Textarea::make('meta_keywords')
                                            ->label('Meta Keywords')
                                            ->placeholder('Enter keywords for SEO')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->placeholder('Enter a brief description for SEO')
                                            ->maxLength(500)
                                            ->columnSpanFull(),
                                        RichEditor::make('description')
                                            ->label('Product Description')
                                            ->placeholder('Enter the full product description')
                                            ->columnSpanFull(),
                                    ])->columnSpanFull()
                            ]),
                        Tab::make('Product Gallery Images')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make('Product Gallery Images')
                                    ->description('Upload multiple images for the product gallery.')
                                    ->schema([
                                        FileUpload::make('gallery_images')
                                            ->label('Gallery Images')
                                            ->multiple()
                                            ->image()
                                            ->maxSize(2048)
                                            ->rules(['mimes:png,jpg,jpeg,gif'])
                                            ->disk('public') // assuming 'public' disk (storage/app/public)
                                            ->directory('gallery_images') // where images are stored
                                            ->default(
                                                fn($record) => $record?->gallery?->images
                                                    ? collect($record->gallery->images)->map(fn($img) => "gallery_images/{$img}")->toArray()
                                                    : []
                                            )
                                            ->visibility('public')
                                            ->preserveFilenames()
                                            ->reorderable()
                                            ->openable()
                                            ->previewable()
                                            ->columnSpanFull()
                                    ])->columnSpanFull()
                            ]),

                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->square()
                    ->size(50)->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()->sortable(),
                ToggleColumn::make('status'),
                TextColumn::make('variants.name')
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
            VariantsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
