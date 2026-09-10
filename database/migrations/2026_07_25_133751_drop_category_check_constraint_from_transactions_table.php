<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'pgsql') {
            // PostgreSQL: 制約の存在確認と削除の書き方が異なる
            $constraintExists = DB::select("
                SELECT constraint_name 
                FROM information_schema.table_constraints 
                WHERE table_name = 'transactions' 
                AND constraint_name = 'transactions_category_check'
                AND table_schema = current_schema()
            ");

            if (!empty($constraintExists)) {
                DB::statement('ALTER TABLE transactions DROP CONSTRAINT transactions_category_check');
            }
        } else {
            // MySQL: 従来通り
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
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT transactions_category_check CHECK (category IN ('entertainment', 'food', 'daily_goods', 'communication', 'utility', 'other'))");
    }
};