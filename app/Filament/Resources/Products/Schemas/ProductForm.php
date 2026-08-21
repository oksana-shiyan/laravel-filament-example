<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basics')
                    ->description('Core product identity and category.')
                    ->icon(Heroicon::OutlinedShoppingBag)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->inline(false),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
                Section::make('Pricing & inventory')
                    ->description('Sale price and available stock.')
                    ->icon(Heroicon::OutlinedCube)
                    ->columns(2)
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$'),
                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Stock badges on the list use 0 / ≤10 / 11+ thresholds.'),
                    ]),
                Section::make('Meta')
                    ->description('Optional key-value attributes stored as JSON.')
                    ->icon(Heroicon::OutlinedTag)
                    ->collapsed()
                    ->schema([
                        KeyValue::make('meta')
                            ->label('Attributes')
                            ->keyLabel('Key')
                            ->valueLabel('Value')
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
                Section::make('Comments')
                    ->description('Customer or internal notes for this product.')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->collapsed()
                    ->schema([
                        Repeater::make('comments')
                            ->relationship()
                            ->schema([
                                TextInput::make('author')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('body')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['author'] ?? null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
