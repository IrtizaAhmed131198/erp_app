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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('entry_id')->nullable();
            $table->string('department')->nullable();
            $table->string('work_center')->nullable();
            $table->string('planning')->nullable();
            $table->string('status')->nullable();
            $table->string('job')->nullable();
            $table->string('lot')->nullable();
            $table->string('ids')->nullable();
            $table->string('customer')->nullable();
            $table->string('rev')->nullable();
            $table->string('process')->nullable();
            $table->string('in_process_outside')->nullable();
            $table->string('raw_mat')->nullable();
            $table->string('wt_pc')->nullable();
            $table->string('material')->nullable();
            $table->string('safety')->nullable();
            $table->text('order_notes')->nullable();
            $table->text('part_notes')->nullable();
            $table->string('future_raw')->nullable();
            $table->string('price')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
