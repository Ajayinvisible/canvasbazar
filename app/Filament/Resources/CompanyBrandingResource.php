<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyBrandingResource\Pages;
use App\Filament\Resources\CompanyBrandingResource\RelationManagers;
use App\Models\Company;
use App\Models\CompanyBranding;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class CompanyBrandingResource extends Resource
{
    protected static ?string $model = CompanyBranding::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $navigationGroup = 'Company';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company Branding')
                    ->schema([
                        Select::make('company_id')
                            ->label('Company')->required()
                            ->relationship('company', 'name')
                            ->default(fn() => Company::query()->value('id'))
                            ->columnSpan('full')->required(),
                        FileUpload::make('logo')->label('Company Logo')
                            ->required()
                            ->rules(['image', 'mimes:png,jpg,jpeg,gif', 'max:2048']),
                        FileUpload::make('favicon')->label('Company Favicon')
                            ->required()
                            ->rules(['image', 'mimes:png,jpg,jpeg,gif', 'max:2048']),
                        TextInput::make('copyright')
                            ->label('Company Copyright')
                            ->columnSpan('full'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company.name'),
                ImageColumn::make('logo'),
                ImageColumn::make('favicon'),
                TextColumn::make('copyright'),
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
            'index' => Pages\ListCompanyBrandings::route('/'),
            'create' => Pages\CreateCompanyBranding::route('/create'),
            'edit' => Pages\EditCompanyBranding::route('/{record}/edit'),
        ];
    }
}
