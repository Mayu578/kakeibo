<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedCost extends Model
{
    protected $fillable = [
        'account_id',
        'name',
        'amount',
        'withdrawal_day',
        'end_date',
        'user_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
