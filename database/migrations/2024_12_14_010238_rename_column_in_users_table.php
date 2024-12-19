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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('successful_payments', 'status_column');
            $table->renameColumn('payouts', 'stock_finished_column');
            $table->renameColumn('fee_collection', 'part_number_column');
            $table->renameColumn('customer_payment_dispute', 'calendar_column');
            $table->renameColumn('refund_alerts', 'input_screen_column');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
