<?php

namespace App\Http\Controllers;


use App\Models\FixedCost;
use App\Models\Account;
use Illuminate\Http\Request;


class FixedCostController extends Controller
{

    public function index()
    {
        $fixedCosts = FixedCost::with('account')->get();
        return view('fixed_costs.index', compact('fixedCosts'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('fixed_costs.create', compact('accounts'));
    }

    public function store(Request $request)
    {



        // 1. バリデーション（終了日は null であっても良い）
        $validated = $request->validate([
            'account_id' => 'required|integer',
            'name' => 'required|string',
            'amount' => 'required|integer',
            'withdrawal_day' => 'required|integer|min:1|max:31',
            'end_date' => 'nullable|date',
        ]);


        // 3. 保存
        \App\Models\FixedCost::create($validated);

        return redirect()->route('fixed-costs.index')->with('success', '登録しました');
    }

    public function destroy(FixedCost $fixedCost)
    {
        $fixedCost->delete();

        return redirect()->route('fixed-costs.index');
    }
}
