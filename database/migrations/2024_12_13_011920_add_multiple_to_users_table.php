<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('successful_payments')->nullable();
            $table->string('payouts')->nullable();
            $table->string('fee_collection')->nullable();
            $table->string('customer_payment_dispute')->nullable();
            $table->string('refund_alerts')->nullable();
            $table->string('invoice_payments')->nullable();
            $table->string('webhook_api_endpoints')->nullable();
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
