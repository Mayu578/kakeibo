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
        $transactions = Transaction::with('account')
            ->orderBy('transaction_date', 'desc')
            ->get();


            // ① 月を取得（未指定なら今月）
        $month = $request->input('month', now()->format('Y-m'));

           // ② 年と月に分解
        $date = Carbon::createFromFormat('Y-m', $month);

         // ③ 月で絞り込み
        $transactions = Transaction::whereYear('transaction_date', $date->year)
            ->whereMonth('transaction_date', $date->month)
            ->orderBy('transaction_date')
            ->get();


        // 支出だけ集計
        $expenses = Transaction::with('account')
            ->where('type', 'expense')
            ->whereYear('transaction_date', $date->year)
            ->whereMonth('transaction_date', $date->month)
            ->selectRaw('account_id, SUM(amount) as total')
            ->groupBy('account_id')
            ->get();

        $labels = $expenses->map(function ($item) {
            return $item->account->name;
        });

        $data = $expenses->pluck('total');

        // ④ Bladeに渡す
        return view('transactions.index', compact(
            'transactions',
            'labels',
            'data',
            'month'
        ));
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
