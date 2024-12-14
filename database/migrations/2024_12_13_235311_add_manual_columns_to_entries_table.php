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
        Schema::table('entries', function (Blueprint $table) {
            $table->after('notes', function (Blueprint $table) {
                $table->string('planning')->nullable();
                $table->string('status')->nullable();
                $table->string('job')->nullable();
                $table->string('lot')->nullable();
                $table->string('in_stock_finish')->nullable();
                $table->string('in_process_outside')->nullable();
                $table->string('raw_mat')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('planning');
            $table->dropColumn('status');
            $table->dropColumn('job');
            $table->dropColumn('lot');
            $table->dropColumn('in_stock_finish');
            $table->dropColumn('in_process_outside');
            $table->dropColumn('raw_mat');
        });
    }
};
