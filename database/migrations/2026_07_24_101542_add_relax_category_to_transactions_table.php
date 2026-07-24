<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN category ENUM(
            'entertainment',
            'food',
            'dining_out',
            'daily_goods',
            'communication',
            'utility',
            'relax',
            'other'
        ) DEFAULT 'other'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN category ENUM(
            'entertainment',
            'food',
            'dining_out',
            'daily_goods',
            'communication',
            'utility',
            'other'
        ) DEFAULT 'other'");
    }
};
