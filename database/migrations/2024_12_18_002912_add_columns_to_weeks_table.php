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
        Schema::table('weeks', function (Blueprint $table) {
            $table->string('week_1_date')->nullable()->after('week_1');
            $table->string('week_2_date')->nullable()->after('week_2');
            $table->string('week_3_date')->nullable()->after('week_3');
            $table->string('week_4_date')->nullable()->after('week_4');
            $table->string('week_5_date')->nullable()->after('week_5');
            $table->string('week_6_date')->nullable()->after('week_6');
            $table->string('week_7_date')->nullable()->after('week_7');
            $table->string('week_8_date')->nullable()->after('week_8');
            $table->string('week_9_date')->nullable()->after('week_9');
            $table->string('week_10_date')->nullable()->after('week_10');
            $table->string('week_11_date')->nullable()->after('week_11');
            $table->string('week_12_date')->nullable()->after('week_12');
            $table->string('week_13_date')->nullable()->after('week_13');
            $table->string('week_14_date')->nullable()->after('week_14');
            $table->string('week_15_date')->nullable()->after('week_15');
            $table->string('week_16_date')->nullable()->after('week_16');
            $table->string('month_5_date')->nullable()->after('month_5');
            $table->string('month_6_date')->nullable()->after('month_6');
            $table->string('month_7_date')->nullable()->after('month_7');
            $table->string('month_8_date')->nullable()->after('month_8');
            $table->string('month_9_date')->nullable()->after('month_9');
            $table->string('month_10_date')->nullable()->after('month_10');
            $table->string('month_11_date')->nullable()->after('month_11');
            $table->string('month_12_date')->nullable()->after('month_12');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weeks', function (Blueprint $table) {
            $table->dropColumn('week_1_date');
            $table->dropColumn('week_2_date');
            $table->dropColumn('week_3_date');
            $table->dropColumn('week_4_date');
            $table->dropColumn('week_5_date');
            $table->dropColumn('week_6_date');
            $table->dropColumn('week_7_date');
            $table->dropColumn('week_8_date');
            $table->dropColumn('week_9_date');
            $table->dropColumn('week_10_date');
            $table->dropColumn('week_11_date');
            $table->dropColumn('week_12_date');
            $table->dropColumn('week_13_date');
            $table->dropColumn('week_14_date');
            $table->dropColumn('week_15_date');
            $table->dropColumn('week_16_date');
            $table->dropColumn('month_5_date');
            $table->dropColumn('month_6_date');
            $table->dropColumn('month_7_date');
            $table->dropColumn('month_8_date');
            $table->dropColumn('month_9_date');
            $table->dropColumn('month_10_date');
            $table->dropColumn('month_11_date');
            $table->dropColumn('month_12_date');
        });
    }
};
