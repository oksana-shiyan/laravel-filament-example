<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('catalog.fields.name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        $operator = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';

                        return $query
                            ->where('name->en', $operator, "%{$search}%")
                            ->orWhere('name->uk', $operator, "%{$search}%");
                    })
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('sku')
                    ->label(__('catalog.fields.sku'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('category.name')
                    ->label(__('catalog.fields.category'))
                    ->badge()
                    ->color('info')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('price')
                    ->label(__('catalog.fields.price'))
                    ->money()
                    ->sortable(),
                TextColumn::make('stock')
                    ->label(__('catalog.fields.stock'))
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),
                IconColumn::make('is_active')
                    ->label(__('catalog.fields.active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label(__('catalog.fields.category')),
                TernaryFilter::make('is_active')
                    ->label(__('catalog.fields.active')),
                SelectFilter::make('stock_level')
                    ->label(__('catalog.fields.stock_level'))
                    ->options([
                        'out' => __('catalog.fields.stock_out'),
                        'low' => __('catalog.fields.stock_low'),
                        'ok' => __('catalog.fields.stock_ok'),
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'out' => $query->where('stock', 0),
                            'low' => $query->whereBetween('stock', [1, 10]),
                            'ok' => $query->where('stock', '>', 10),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                Action::make('restock')
                    ->label(__('catalog.fields.restock'))
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->color('success')
                    ->modalHeading(__('catalog.fields.restock_heading'))
                    ->modalDescription(fn (Product $record): string => __('catalog.fields.restock_description', [
                        'name' => $record->name,
                        'stock' => $record->stock,
                    ]))
                    ->modalSubmitActionLabel(__('catalog.fields.restock_submit'))
                    ->schema([
                        TextInput::make('quantity')
                            ->label(__('catalog.fields.quantity'))
                            ->numeric()
                            ->integer()
                            ->required()
                            ->minValue(1)
                            ->default(10)
                            ->helperText(__('catalog.fields.quantity_helper')),
                    ])
                    ->action(function (Product $record, array $data): void {
                        $quantity = (int) $data['quantity'];
                        $record->increment('stock', $quantity);

                        Notification::make()
                            ->title(__('catalog.fields.stock_updated'))
                            ->body(__('catalog.fields.stock_updated_body', [
                                'quantity' => $quantity,
                                'name' => $record->name,
                                'stock' => $record->fresh()->stock,
                            ]))
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markInactive')
                        ->label(__('catalog.fields.mark_inactive'))
                        ->icon(Heroicon::OutlinedXCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);

                            Notification::make()
                                ->title(__('catalog.fields.products_updated'))
                                ->body(__('catalog.fields.products_marked_inactive', [
                                    'count' => $records->count(),
                                ]))
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading(__('catalog.fields.empty_heading'))
            ->emptyStateDescription(__('catalog.fields.empty_description'))
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }
}
