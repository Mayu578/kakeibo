<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fixed_costs', function (Blueprint $table) {
            // accountsの後に user_id カラムを追加（外部キー制約付き）
            $table->foreignId('user_id')->nullable()->after('account_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('fixed_costs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
