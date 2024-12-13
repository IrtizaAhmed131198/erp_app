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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('part_number')->nullable();
            $table->string('customer')->nullable();
            $table->string('revision')->nullable();
            $table->string('process')->nullable();
            $table->string('department')->nullable();
            $table->string('work_centre_1')->nullable();
            $table->string('work_centre_2')->nullable();
            $table->string('work_centre_3')->nullable();
            $table->string('work_centre_4')->nullable();
            $table->string('work_centre_5')->nullable();
            $table->string('work_centre_6')->nullable();
            $table->string('work_centre_7')->nullable();
            $table->string('outside_processing_1')->nullable();
            $table->string('outside_processing_2')->nullable();
            $table->string('outside_processing_3')->nullable();
            $table->string('outside_processing_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
