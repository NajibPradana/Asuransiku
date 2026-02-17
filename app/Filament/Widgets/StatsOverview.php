<?php

namespace App\Filament\Widgets;

use App\Models\Claim;
use App\Models\Policy;
use App\Models\Product;
use App\Models\User;
use App\Support\NumberFormatter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverview extends BaseWidget
{
    protected ?string $heading = 'Statistik Aplikasi';

    protected function getStats(): array
    {
        $labels = collect(range(6, 0))->map(fn(int $daysAgo) => now()->subDays($daysAgo)->startOfDay());

        $usersChart = $labels->map(fn(Carbon $date) => User::whereDate('created_at', $date)->count())->all();
        $productsChart = $labels->map(fn(Carbon $date) => Product::where('is_active', true)->whereDate('created_at', $date)->count())->all();
        $policiesChart = $labels->map(fn(Carbon $date) => Policy::where('status', 'pending')->whereDate('created_at', $date)->count())->all();
        $claimsChart = $labels->map(fn(Carbon $date) => Claim::whereIn('status', ['pending', 'review'])->whereDate('created_at', $date)->count())->all();

        return [
            Stat::make('Total Users', NumberFormatter::formatNumber(User::count(), 0))
                ->description('Pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart($usersChart),

            Stat::make('Produk Asuransi Aktif', NumberFormatter::formatNumber(Product::where('is_active', true)->count(), 0))
                ->description('Produk tersedia')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success')
                ->chart($productsChart),

            Stat::make('Polis Pending', NumberFormatter::formatNumber(Policy::where('status', 'pending')->count(), 0))
                ->description('Menunggu persetujuan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->chart($policiesChart),

            Stat::make('Klaim Pending', NumberFormatter::formatNumber(Claim::whereIn('status', ['pending', 'review'])->count(), 0))
                ->description('Perlu verifikasi')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger')
                ->chart($claimsChart),
        ];
    }
}
