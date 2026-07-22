<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MonthlyComment;
use App\Http\Requests\StoreMonthlyCommentRequest;

class MonthlyCommentController extends Controller
{
    public function index(string $month)
    {
        $comments = MonthlyComment::forMonth($month)->latest()->get();

        return view('monthly-summaries.show', compact('month', 'comments'));
    }

    public function store(StoreMonthlyCommentRequest $request, string $month)
    {
        MonthlyComment::create([
            'user_id' => $request->user()->id,
            'month' => $month,
            'comment' => $request->validated()['comment'],
        ]);

        return back()->with('status', 'コメントを投稿しました');
    }

    public function destroy(MonthlyComment $monthlyComment)
    {
        $this->authorize('delete', $monthlyComment);

        $monthlyComment->delete();

        return back()->with('status', 'コメントを削除しました');
    }
}
