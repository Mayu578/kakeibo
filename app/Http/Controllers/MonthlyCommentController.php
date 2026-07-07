<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MonthlyComment;

class MonthlyCommentController extends Controller
{

    public function dashboard(Request $request)
    {
    
        $month = $request->input('month', now()->format('Y-m'));

        $comments = MonthlyComment::where('month', $month)->get();

        return view('dashboard', compact('month', 'comments'));
    }

    public function saveComment(Request $request)
    {
        \App\Models\MonthlyComment::create(
            [
                'month' => $request->month, // ← 月で識別
                'comment' => $request->comment
            ]
        );

        return redirect()->route('dashboard', [
            'month' => $request->month // ← 同じ月に戻す
        ])->with('success', '保存しました');
    }

    public function deleteComment(Request $request)
    {
        // フォームから送られてきた comment_id を取得
        $commentId = $request->input('comment_id');

        // 該当するデータをデータベースから削除
        MonthlyComment::destroy($commentId);

        // 成功メッセージとともにダッシュボードにリダイレクト
        return redirect()->route('dashboard')->with('success', '感想を削除しました。');
    }
}
