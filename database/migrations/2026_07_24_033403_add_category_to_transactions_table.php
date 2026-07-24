<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('category', [
                'entertainment', // 娯楽費
                'food',          // 食費
                'daily_goods',   // 日用品費
                'communication', // 通信費
                'utility',       // 光熱費
                'other',         // その他
            ])->default('other')->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};