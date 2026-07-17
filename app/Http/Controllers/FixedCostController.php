<?php

namespace App\Http\Controllers;


use App\Models\FixedCost;
use App\Models\Account;
use Illuminate\Http\Request;


class FixedCostController extends Controller
{

    public function index()
    {
        $today = now()->toDateString(); // 今日の日付（2026-07-15）を取得

        // ログインユーザーの固定費のうち、
        // 「終了日が空（null）」または「終了日が今日以降（未来）」のものだけを取得する
        $fixedCosts = FixedCost::where('user_id', auth()->id())
            ->where(function ($query) use ($today) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $today);
            })
            ->with('account')
            ->get();

        return view('fixed_costs.index', compact('fixedCosts'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('fixed_costs.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'withdrawal_day' => 'required|integer|min:1|max:31',
            'end_date' => 'nullable|date',
        ]);

        // ログインユーザーのIDをセットして作成
        $validated['user_id'] = auth()->id();

        FixedCost::create($validated);

        return redirect()->route('fixed_costs.index')
            ->with('success', '固定費を登録しました。');
    }

    public function destroy(FixedCost $fixedCost)
    {
        $fixedCost->delete();

        return redirect()->route('fixed-costs.index');
    }
}
