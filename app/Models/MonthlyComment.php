<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyComment extends Model
{
    protected $fillable = [
        'month',
        'comment',
    ];
}
