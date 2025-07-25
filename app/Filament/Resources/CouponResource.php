<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Coupon Details')
                    ->schema([
                        TextInput::make('code')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(50)
                            ->label('Coupon Code'),
                        Select::make('type')
                            ->options([
                                'percentage' => 'Percentage',
                                'fixed' => 'Fixed Amount',
                            ]),
                        TextInput::make('value')
                            ->numeric()
                            ->required()
                            ->label('Discount Value'),
                        TextInput::make('min_order_amount')
                            ->numeric()
                            ->default(0)
                            ->label('Minimum Order Amount'),
                        TextInput::make('max_discount')
                            ->numeric()
                            ->nullable()
                            ->label('Maximum Discount (for percentage)'),
                        DatePicker::make('start_date')
                            ->required()
                            ->label('Valid From'),
                        DatePicker::make('end_date')
                            ->required()
                            ->label('Valid Until'),
                        Toggle::make('status')
                            ->default(true)
                            ->label('Active'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('code')->sortable()->searchable(),
                TextColumn::make('type')->sortable()->searchable(),
                TextColumn::make('value')
                    ->formatStateUsing(fn($state) => number_format($state, 2)),
                TextColumn::make('min_order_amount')
                    ->formatStateUsing(fn($state) => number_format($state, 2))
                    ->label('Min Order Amount'),
                TextColumn::make('max_discount')
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 2) : 'N/A')
                    ->label('Max Discount'),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Valid From')->sortable()->searchable(),
                TextColumn::make('end_date')
                    ->date()
                    ->label('Valid Until')->sortable()->searchable(),
                ToggleColumn::make('status')->sortable()->searchable(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
