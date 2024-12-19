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
            $table->after('raw_mat', function (Blueprint $table) {
                $table->string('rev')->nullable();
                $table->string('wet_reqd')->nullable();
                $table->string('safety')->nullable();
                $table->string('min_ship')->nullable();
                $table->string('wt_pc')->nullable();
                $table->string('live_inventory_finish')->nullable();
                $table->string('in_stock_live')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('rev');
            $table->dropColumn('wet_reqd');
            $table->dropColumn('safety');
            $table->dropColumn('min_ship');
            $table->dropColumn('wt_pc');
            $table->dropColumn('live_inventory_finish');
            $table->dropColumn('in_stock_live');
        });
    }
};
