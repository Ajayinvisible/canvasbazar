<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use function Laravel\Prompts\select;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Create Company')->tabs([
                    Tab::make('Company')
                        ->icon('heroicon-o-computer-desktop')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            TextInput::make('name')->columnSpan('full')->label('Company Name')->required(),
                            TextInput::make('email')->label('Company Email')->email()->required(),
                            TextInput::make('address')->label('Company Address')->required(),
                            RichEditor::make('description')->columnSpan('full'),
                        ])->columns(2),
                    Tab::make('Meta Properties')
                        ->icon('heroicon-o-document-magnifying-glass')
                        ->iconPosition(IconPosition::Before)
                        ->schema([
                            RichEditor::make('meta_keywords')->columnSpan('full'),
                            RichEditor::make('meta_description')->columnSpan('full'),
                            Textarea::make('google_map')->label('Google Embed Map')
                        ])
                ])->columnSpan('full')
            ]);
    }

    public static function table(table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('address'),
                TextColumn::make('description')->html()->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
