<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;

use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class WaitingTransactions extends BaseWidget
{

    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::query()->whereStatus('waiting')
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('artwork.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn(string $state): string => match ($state) {
                    'waiting' => 'gray',
                    'approved' => 'info',
                    'cancelled' => 'danger',
                }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->actions([
                Action::make('approve')
                    ->button()
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Transaction $transaction) {
                        Transaction::find($transaction->id)->update([
                            'status' => 'approved',
                        ]);
                        Notification::make()->success()->title('Transaction Approved')->body('Transaction has been approved successfully')->icon('heroicon-o-check')->send();
                    })
                    ->hidden(fn(Transaction $transaction) => $transaction->status !== 'waiting'),
            ]);
    }
}
