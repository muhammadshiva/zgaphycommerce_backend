<?php

namespace App\Filament\Widgets;

use App\Models\Artwork;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    private function getPercentage(float $from, float $to)
    {
        // Pastikan tidak ada pembagian dengan nol
        if ($to + $from / 2 == 0) {
            return 0;
        }
        return ($to - $from) / ($to + $from / 2) * 100;
    }

    protected function getStats(): array
    {
        // Jumlah artwork baru bulan ini
        $newArtwork = Artwork::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Query transaksi yang disetujui bulan ini
        $transactions = Transaction::whereStatus('approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year);

        // Query transaksi yang disetujui bulan lalu
        $prevTransaction = Transaction::whereStatus('approved')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year);

        // Hitung total jumlah transaksi (count)
        $transactionCount = $transactions->count();
        $prevTransactionCount = $prevTransaction->count();

        // Hitung persentase perubahan transaksi
        $transactionPercentage = $this->getPercentage($prevTransactionCount, $transactionCount);

        // Hitung total revenue
        $transactionRevenue = $transactions->sum('total_price');
        $prevTransactionRevenue = $prevTransaction->sum('total_price');

        // Hitung persentase perubahan revenue
        $revenuePercentage = $this->getPercentage($prevTransactionRevenue, $transactionRevenue);

        // Return stats untuk widget
        return [
            Stat::make('New artwork of the month', $newArtwork),
            Stat::make('Transaction of the month', $transactionCount)
                ->description($transactionPercentage > 0 ? "{$transactionPercentage}% increased" : "{$transactionPercentage}% decreased")
                ->descriptionIcon($transactionPercentage > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($transactionPercentage > 0 ? 'success' : 'danger'),

            Stat::make('Revenue of the month', Number::currency($transactionRevenue, 'IDR'))
                ->description($revenuePercentage > 0 ? "{$revenuePercentage}% increased" : "{$revenuePercentage}% decreased")
                ->descriptionIcon($revenuePercentage > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenuePercentage > 0 ? 'success' : 'danger'),
        ];
    }
}
