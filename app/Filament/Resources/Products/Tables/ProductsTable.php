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
use Illuminate\Database\Eloquent\Collection;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('info')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                SelectFilter::make('stock_level')
                    ->label('Stock level')
                    ->options([
                        'out' => 'Out of stock',
                        'low' => 'Low (1–10)',
                        'ok' => 'In stock (11+)',
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
                    ->label('Restock')
                    ->icon(Heroicon::OutlinedPlusCircle)
                    ->color('success')
                    ->modalHeading('Restock product')
                    ->modalDescription(fn (Product $record): string => "Current stock for {$record->name}: {$record->stock}")
                    ->modalSubmitActionLabel('Add stock')
                    ->schema([
                        TextInput::make('quantity')
                            ->label('Quantity to add')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->minValue(1)
                            ->default(10)
                            ->helperText('Enter how many units to add to stock.'),
                    ])
                    ->action(function (Product $record, array $data): void {
                        $quantity = (int) $data['quantity'];
                        $record->increment('stock', $quantity);

                        Notification::make()
                            ->title('Stock updated')
                            ->body("Added {$quantity} units. {$record->name} now has {$record->fresh()->stock} units.")
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markInactive')
                        ->label('Mark inactive')
                        ->icon(Heroicon::OutlinedXCircle)
                        ->color('warning')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);

                            Notification::make()
                                ->title('Products updated')
                                ->body($records->count().' product(s) marked inactive.')
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No products yet')
            ->emptyStateDescription('Create a product to get started.')
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }
}
