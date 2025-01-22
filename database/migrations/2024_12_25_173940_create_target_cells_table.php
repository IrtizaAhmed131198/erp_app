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
        Schema::create('target_cells', function (Blueprint $table) {
            $table->id();
            $table->integer('notification_id');
            $table->string('table');
            $table->integer('ref_id');
            $table->string('field');
            $table->text('old')->nullable();
            $table->text('new')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_cells');
    }
};
