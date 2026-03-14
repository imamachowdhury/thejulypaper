<?php

namespace App\Filament\Resources\MenuLinks;

use App\Filament\Resources\MenuLinks\Pages;
use App\Models\MenuLink;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MenuLinkResource extends Resource
{
    protected static ?string $model = MenuLink::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-link';

    protected static string | \UnitEnum | null $navigationGroup = 'Navigation';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->required(),

                Forms\Components\Select::make('type')
                    ->options([
                        'category' => 'Category',
                        'page' => 'Static Page',
                        'custom' => 'Custom URL',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),

                Forms\Components\Select::make('page_id')
                    ->label('Static Page')
                    ->relationship('page', 'title'),

                Forms\Components\TextInput::make('url')
                    ->label('Custom URL')
                    ->placeholder('https://...'),

                Forms\Components\Select::make('location')
                    ->options([
                        'primary' => 'Primary Menu (Header)',
                        'footer' => 'Footer Menu',
                    ])
                    ->default('primary')
                    ->required(),

                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('location')->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options([
                        'primary' => 'Primary',
                        'footer' => 'Footer',
                    ])
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMenuLinks::route('/'),
        ];
    }
}
