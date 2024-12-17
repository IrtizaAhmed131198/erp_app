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
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('part_number');
            $table->string('week_1')->nullable();
            $table->string('week_2')->nullable();
            $table->string('week_3')->nullable();
            $table->string('week_4')->nullable();
            $table->string('week_5')->nullable();
            $table->string('week_6')->nullable();
            $table->string('week_7')->nullable();
            $table->string('week_8')->nullable();
            $table->string('week_9')->nullable();
            $table->string('week_10')->nullable();
            $table->string('week_11')->nullable();
            $table->string('week_12')->nullable();
            $table->string('week_13')->nullable();
            $table->string('week_14')->nullable();
            $table->string('week_15')->nullable();
            $table->string('week_16')->nullable();
            $table->string('month_5')->nullable();
            $table->string('month_6')->nullable();
            $table->string('month_7')->nullable();
            $table->string('month_8')->nullable();
            $table->string('month_9')->nullable();
            $table->string('month_10')->nullable();
            $table->string('month_11')->nullable();
            $table->string('month_12')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weeks');
    }
};
