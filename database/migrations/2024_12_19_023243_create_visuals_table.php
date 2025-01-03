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
        Schema::create('visuals', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('customer')->nullable();
            $table->string('part_number')->nullable();
            $table->string('quantity')->nullable();
            $table->string('job')->nullable();
            $table->string('lot')->nullable();
            $table->string('type')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visuals');
    }
};
