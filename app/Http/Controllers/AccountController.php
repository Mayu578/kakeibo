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
        $accounts = Account::all();  //裏でphpがsqlに変換し、DBからデータ操作している

        $total = Account::sum('balance');

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
            'type' => 'required|string', // 追加
        ]);

        Account::create([
            'name' => $request->name,
            'balance' => $request->balance,
            'type' => $request->type, // 追加
        ]);

        return redirect()->route('accounts.index');
    }

    public function destroy($id)
    {
        // 指定した口座を削除
        $account = \App\Models\Account::findOrFail($id);
        $account->delete();

        // 削除後に一覧へリダイレクト（メッセージ付き）
        return redirect()->route('accounts.index')->with('success', '口座を削除しました。');
    }

    public function editBalance(Account $account)
    {
        return view('accounts.edit-balance', compact('account'));
    }

    public function updateBalance(Request $request, Account $account)
    {
        $request->validate([
            'balance' => 'required|numeric'
        ]);

        $account->balance = $request->balance;
        $account->save();

        return redirect()->route('accounts.index')
            ->with('success', '残高を更新しました'); // ← これ大事
    }


    public function dashboard(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        // 🔽 追加：年月分解
        $date = \Carbon\Carbon::parse($month);
        $lastDayOfMonth = $date->copy()->endOfMonth(); // その月の末日（例: 2026-05-31）
        $year = $date->year;
        $monthNum = $date->month;

        $accounts = Account::all();

        // 🔽 月ごとの取引
        $transactions = Transaction::with('account')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $total = $accounts->sum('balance');

        // 支出
        $totalExpense = Transaction::where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->sum('amount');

        // 収入
        $totalIncome = Transaction::where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $monthNum)
            ->sum('amount');

        // 固定費
        // その月の「月末日」時点で有効なものだけを抽出する
        $totalFixedCost = FixedCost::where(function ($query) use ($lastDayOfMonth) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', $lastDayOfMonth);
        })->sum('amount');

        // 差額
        $balance = $totalIncome - ($totalExpense + $totalFixedCost);

        // コメント
        $comments = \App\Models\MonthlyComment::where('month', $month)->get();

        return view('dashboard', compact(
            'accounts',
            'transactions',
            'total',
            'totalExpense',
            'totalIncome',
            'balance',
            'totalFixedCost',
            'month',
            'comments'
        ));
    }
}
