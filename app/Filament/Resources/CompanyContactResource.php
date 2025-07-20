<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyContactResource\Pages;
use App\Filament\Resources\CompanyContactResource\RelationManagers;
use App\Models\Company;
use App\Models\CompanyContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\TextColumn;

class CompanyContactResource extends Resource
{
    protected static ?string $model = CompanyContact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationGroup = 'Company';

    protected static ?int $navigationSort = 3;

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
                            ->required(),
                        TextInput::make('number')
                            ->required()
                            ->rules('max:15'),
                        Select::make('type')->required()
                            ->options([
                                'phone' => 'Phone',
                                'whatsapp' => 'Whatsapp',
                                'viber' => 'Viber',
                                'support' => 'Support'
                            ]),
                        FileUpload::make('icon')
                            ->rules('image|mimes:png|max:150'),
                        Toggle::make('status'),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('company.name'),
                ImageColumn::make('icon'),
                TextColumn::make('number')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                ToggleColumn::make('status')->sortable()->searchable()
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
            'index' => Pages\ListCompanyContacts::route('/'),
            'create' => Pages\CreateCompanyContact::route('/create'),
            'edit' => Pages\EditCompanyContact::route('/{record}/edit'),
        ];
    }
}
