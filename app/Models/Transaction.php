<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'transaction_date',
        'reflect_date',
        'description',
        'payment_type',
        'due_date',
        'user_id',
    ];



    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function fixedCost()
    {
        return $this->belongsTo(FixedCost::class);
    }



    public function reflect()
    {
        // 既に反映済みなら何もしない
        if ($this->reflect_date !== null) {
            return;
        }

        // クレジットの場合、引き落とし日がまだ来ていなければ反映しない
        if ($this->payment_type === 'credit' && $this->due_date && now()->lt($this->due_date)) {
            return;
        }

        $account = $this->account;

        if (!$account) {
            return; // 関連する口座が存在しない場合は何もしない
        }

        // 残高更新
        if ($this->type === 'income') {
            $account->balance += $this->amount;
        } else { // expense
            $account->balance -= $this->amount;
        }

        $account->save();

        // 反映済みとして日付を記録
        $this->reflect_date = now();
        $this->save();
    }

    public function user()
    {
        // 取引は、1人のユーザーに所属します
        return $this->belongsTo(User::class);
    }
}
