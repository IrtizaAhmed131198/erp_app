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
        Schema::table('work_center', function (Blueprint $table) {
            $table->string('work_centre_id')->nullable()->after('com');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_center', function (Blueprint $table) {
            $table->dropColumn('work_centre_id');
        });
    }
};
