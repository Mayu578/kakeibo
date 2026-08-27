<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 制約が存在する場合のみ削除
        $constraintExists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.TABLE_CONSTRAINTS 
            WHERE TABLE_NAME = 'transactions' 
            AND CONSTRAINT_NAME = 'transactions_category_check'
            AND TABLE_SCHEMA = DATABASE()
        ");

        if (!empty($constraintExists)) {
            DB::statement('ALTER TABLE transactions DROP CHECK transactions_category_check');
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT transactions_category_check CHECK (category IN ('entertainment', 'food', 'daily_goods', 'communication', 'utility', 'other'))");
    }
};