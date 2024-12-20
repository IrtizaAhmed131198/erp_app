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
        Schema::table('outsource', function (Blueprint $table) {
            $table->string('outside_processing_id')->nullable()->after('in_process_outside');
            $table->string('outside_processing_text_id')->nullable()->after('outside_processing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outsource', function (Blueprint $table) {
            $table->dropColumn('outside_processing_id');
            $table->dropColumn('outside_processing_text_id');
        });
    }
};
