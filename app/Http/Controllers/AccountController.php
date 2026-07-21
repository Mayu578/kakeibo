<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\FixedCost;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index()
    {
        // 【修正】ログインユーザー（mayu）の口座のみ取得
        $accounts = Account::where('user_id', auth()->id())->get();

        // 【修正】ログインユーザーの口座残高の合計のみ算出
        $total = $accounts->sum('balance');

        return view('accounts.index', compact('accounts', 'total'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric',
            'type' => 'required|string',
        ]);

        // 【修正】作成する口座にログインユーザーの ID を紐付ける
        Account::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'balance' => $request->balance,
            'type' => $request->type,
        ]);

        return redirect()->route('accounts.index');
    }

    public function destroy($id)
    {
        // 【修正】他人の口座を削除できないよう、ログインユーザーの口座から探す
        $account = Account::where('user_id', auth()->id())->findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', '口座を削除しました。');
    }

    // 残高編集画面の表示
    public function editBalance(Account $account)
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        return view('accounts.edit-balance', compact('account'));
    }

    // 残高の更新処理
    public function updateBalance(Request $request, Account $account)
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'balance' => 'required|integer',
        ]);

        $account->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', '残高を更新しました。');
    }

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

        $comments = \App\Models\MonthlyComment::where('user_id', $userId)
            ->where('month', $month)
            ->get();

        return view('dashboard', compact(
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
            'comments'
        ));
    }
}
