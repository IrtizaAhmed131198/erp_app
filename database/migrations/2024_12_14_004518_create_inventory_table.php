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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('Serial_No');
            $table->string('Customer_No');
            $table->string('Part_No');
            $table->string('Revision');
            $table->integer('Container_Qty');
            $table->float('Weight');
            $table->string('Location');
            $table->text('Notes');
            $table->timestamp('PrintDate');
            $table->string('Status');
            $table->integer('User_ID');
            $table->string('New_Part')->nullable();
            $table->string('New_Customer')->nullable();
            $table->timestamp('RemoveDate')->nullable();
            $table->string('LotJobNumber');
            $table->string('PackingListNumber');
            $table->string('Package');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
