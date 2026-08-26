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
                Section::make(__('catalog.fields.basics'))
                    ->description(__('catalog.fields.basics_description'))
                    ->icon(Heroicon::OutlinedShoppingBag)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('catalog.fields.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sku')
                            ->label(__('catalog.fields.sku'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->label(__('catalog.fields.category'))
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_active')
                            ->label(__('catalog.fields.active'))
                            ->default(true)
                            ->inline(false),
                        Textarea::make('description')
                            ->label(__('catalog.fields.description'))
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
                Section::make(__('catalog.fields.pricing'))
                    ->description(__('catalog.fields.pricing_description'))
                    ->icon(Heroicon::OutlinedCube)
                    ->columns(2)
                    ->schema([
                        TextInput::make('price')
                            ->label(__('catalog.fields.price'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$'),
                        TextInput::make('stock')
                            ->label(__('catalog.fields.stock'))
                            ->required()
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->helperText(__('catalog.fields.stock_helper')),
                    ]),
                Section::make(__('catalog.fields.meta'))
                    ->description(__('catalog.fields.meta_description'))
                    ->icon(Heroicon::OutlinedTag)
                    ->collapsed()
                    ->schema([
                        KeyValue::make('meta')
                            ->label(__('catalog.fields.attributes'))
                            ->keyLabel(__('catalog.fields.key'))
                            ->valueLabel(__('catalog.fields.value'))
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
                Section::make(__('catalog.fields.comments'))
                    ->description(__('catalog.fields.comments_description'))
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
