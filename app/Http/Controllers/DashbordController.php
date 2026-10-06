<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\FixedCost;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashbordController extends Controller
{
    public function dashboard(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $date = Carbon::parse($month);
        $lastDayOfMonth = $date->copy()->endOfMonth();
        $year = $date->year;
        $monthNum = $date->month;
        $userId = auth()->id();

        $accounts = Account::where('user_id', $userId)->get();

        $transactions = Transaction::where('user_id', $userId)
            ->with('account')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $total = $accounts->sum('balance');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->sum('amount');

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->sum('amount');

        // 【修正】固定費一覧を先に取得し、合計・件数・次回引落日をまとめて算出
        $fixedCosts = FixedCost::where('user_id', $userId)
            ->where(function ($query) use ($lastDayOfMonth) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $lastDayOfMonth);
            })
            ->get();

        $totalFixedCost = $fixedCosts->sum('amount');
        $fixedCostsCount = $fixedCosts->count();

        // 次回引落日（今日以降で一番近いwithdrawal_day。なければ来月の最小日に回す）
        $todayDay = now()->day;
        $nextWithdrawalDay = $fixedCosts->pluck('withdrawal_day')
            ->filter(fn($day) => $day >= $todayDay)
            ->sort()
            ->first() ?? $fixedCosts->pluck('withdrawal_day')->sort()->first();

        $balance = $totalIncome - ($totalExpense + $totalFixedCost);

        $categoryTotals = $transactions
            ->where('type', 'expense')
            ->groupBy('category')
            ->map(fn($group) => $group->sum('amount'));

        $categoryData = $categoryTotals->mapWithKeys(function ($amount, $key) {
            $label = \App\Models\Transaction::CATEGORIES[$key] ?? 'その他';
            return [$label => $amount];
        })
            ->groupBy(fn($amount, $label) => $label)  // 同じラベルをグループ化
            ->map(fn($group) => $group->sum());        // グループ内を合計


        // 支出カレンダー用データ
        $calendarData = $transactions
            ->where('type', 'expense')
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->transaction_date)
                    ->format('Y-m-d');
            })
            ->map(function ($dayTransactions) {

                return $dayTransactions
                    ->groupBy('category')
                    ->map(function ($items) {
                        return $items->sum('amount');
                    });
            });


        // 月の日付カレンダー作成
        $calendar = [];

        for (
            $day = $date->copy()->startOfMonth();
            $day <= $lastDayOfMonth;
            $day->addDay()
        ) {

            $dayString = $day->format('Y-m-d');

            $calendar[] = [
                'date' => $dayString,
                'expenses' => $calendarData[$dayString] ?? []
            ];
        }

        $comments = \App\Models\MonthlyComment::where('user_id', $userId)
            ->where('month', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.index', compact(
            'accounts',
            'transactions',
            'total',
            'totalExpense',
            'totalIncome',
            'balance',
            'totalFixedCost',
            'fixedCosts',
            'fixedCostsCount',
            'nextWithdrawalDay',
            'month',
            'comments',
            'categoryData',
            'calendar'
        ));
    }
}
