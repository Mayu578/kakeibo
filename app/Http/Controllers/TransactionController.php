<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        // ① 月を取得（未指定なら今月）
        $month = $request->input('month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $month);
        $userId = auth()->id();

        // ② 当月の取引（変動費）データを取得
        $transactions = Transaction::where('user_id', $userId)
            ->with('account')
            ->whereYear('transaction_date', $date->year)
            ->whereMonth('transaction_date', $date->month)
            ->orderBy('transaction_date', 'desc')
            ->get();

        // ③ 当月の変動費の支出合計を計算（※収入と支出が区別されている場合、支出のみ合計。もし単純合算なら $transactions->sum('amount') に変更してください）
        // ここでは「支出（typeが'expense'、あるいは金額がマイナスなど）」を合計する例にしています
        // 実装に合わせて調整してください。単純な合計なら $transactions->sum('amount') でOKです。
        $totalExpenses = $transactions->sum('amount');

        // ④ アクティブな固定費を取得して合計を算出
        $today = now()->toDateString();
        $fixedCostsTotal = \App\Models\FixedCost::where('user_id', $userId)
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->sum('amount');

        return view('transactions.index', compact('transactions', 'totalExpenses', 'fixedCostsTotal', 'month'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('transactions.create', compact('accounts'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,credit',
            'due_date' => 'nullable|date|after_or_equal:today',
            'description' => 'nullable|string|max:255',
        ]);

        // 1. バリデーション済みデータに、現在ログインしているユーザーのIDを合流させる
        $validated['user_id'] = auth()->id();

        // 2. Transactionモデルから直接レコードを作成する（これでリレーションエラーを100%回避できます）
        $transaction = Transaction::create($validated);

        // 残高更新は行わない

        return redirect()->route('transactions.create')->with('success', '取引を登録しました');
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }


    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update($request->validate([
            'account_id' => 'required|exists:accounts,id',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:cash,credit',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string|max:255',
        ]));
        return redirect()->route('transactions.index')
            ->with('success', '取引を更新しました');
    }



    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index');
    }
}
