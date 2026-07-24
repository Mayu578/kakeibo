<?php

namespace App\Policies;

use App\Models\MonthlyComment;
use App\Models\User;

class MonthlyCommentPolicy
{
    /**
     * コメントの削除権限：投稿者本人のみ許可
     */
    public function delete(User $user, MonthlyComment $monthlyComment): bool
    {
        return $user->id === $monthlyComment->user_id;
    }

    /**
     * コメントの編集権限：投稿者本人のみ許可
     */
    public function update(User $user, MonthlyComment $monthlyComment): bool
    {
        return $user->id === $monthlyComment->user_id;
    }
}
