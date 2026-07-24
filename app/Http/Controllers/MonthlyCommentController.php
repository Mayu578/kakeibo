<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MonthlyComment;
use App\Http\Requests\StoreMonthlyCommentRequest;

class MonthlyCommentController extends Controller
{
    public function index(string $month)
    {
        $comments = MonthlyComment::forMonth($month)
            ->forUser(auth()->id())
            ->latest()
            ->get();

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

    public function editComment(MonthlyComment $monthlyComment)
    {
        if ($monthlyComment->user_id !== auth()->id()) {
            abort(403);
        }

        return view('monthly-summaries.edit', compact('monthlyComment'));
    }

    public function updateComment(Request $request, MonthlyComment $monthlyComment)
    {
        if ($monthlyComment->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000', // 実際のカラム名に合わせて調整
        ]);

        $monthlyComment->update([
            'content' => $request->content,
        ]);

        return redirect()
            ->route('monthly-comments.index', $monthlyComment->month) // 月の値をどう持っているか要確認
            ->with('success', '更新しました');
    }


    public function destroy(MonthlyComment $monthlyComment)
    {
        $this->authorize('delete', $monthlyComment);

        $monthlyComment->delete();

        return back()->with('status', 'コメントを削除しました');
    }
}
