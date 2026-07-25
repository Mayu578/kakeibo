<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE transactions DROP CONSTRAINT IF EXISTS transactions_category_check');
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT transactions_category_check CHECK (category IN ('entertainment', 'food', 'daily_goods', 'communication', 'utility', 'other'))");
    }
};