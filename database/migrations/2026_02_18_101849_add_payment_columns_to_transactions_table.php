<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // 現金かクレジットかを管理するカラム
            $table->string('payment_type')->default('cash')->after('type');

            // クレジットの引き落とし日。現金は null
            $table->date('due_date')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'due_date']);
        });
    }
};
