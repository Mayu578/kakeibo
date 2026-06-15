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
        $request->validate([
            'account_id' => 'required',
            'name' => 'required',
            'amount' => 'required|integer',
            'withdrawal_day' => 'required|integer|min:1|max:31',
        ]);

        FixedCost::create($request->all());

        return redirect()->route('fixed-costs.index');
    }

    public function destroy(FixedCost $fixedCost)
    {
        $fixedCost->delete();

        return redirect()->route('fixed-costs.index');
    }
}
