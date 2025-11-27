<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Account;
use App\Models\Transaction;

class AccountsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // إجمالي الأرصدة لكل الحسابات
        $totalBalance = Account::all()->sum(function ($account) {
            $income = $account->transactions()->where('txn_type', 'income')->sum('amount');
            $expense = $account->transactions()->where('txn_type', 'expense')->sum('amount');
            return $income - $expense;
        });

        // الإيرادات الشهرية
        $monthlyRevenue = Transaction::where('txn_type', 'income')
            ->whereMonth('txn_date', now()->month)
            ->sum('amount');

        // المصاريف الشهرية
        $monthlyExpenses = Transaction::where('txn_type', 'expense')
            ->whereMonth('txn_date', now()->month)
            ->sum('amount');

        // صافي الربح
        $netProfit = $monthlyRevenue - $monthlyExpenses;

        return [
            Stat::make('إجمالي الأرصدة', number_format($totalBalance) . ' ريال')
                ->description('مجموع جميع الحسابات')
                ->color('success'),

            Stat::make('الإيرادات الشهرية', number_format($monthlyRevenue) . ' ريال')
                ->description('لهذا الشهر')
                ->color('primary'),

            Stat::make('المصاريف الشهرية', number_format($monthlyExpenses) . ' ريال')
                ->description('لهذا الشهر')
                ->color('danger'),

            Stat::make('صافي الربح', number_format($netProfit) . ' ريال')
                ->description('الإيرادات - المصاريف')
                ->color($netProfit >= 0 ? 'success' : 'danger'),
        ];
    }
}
