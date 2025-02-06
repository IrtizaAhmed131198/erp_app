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
        Schema::table('weeks_history', function (Blueprint $table) {
            $table->integer('customer')->after('entry_id');
            $table->integer('department')->after('customer');
            $table->integer('part_number')->after('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weeks_history', function (Blueprint $table) {
            $table->dropColumn('customer');
            $table->dropColumn('department');
            $table->dropColumn('part_number');
        });
    }
};
