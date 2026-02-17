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
        Schema::table('work_forms', function (Blueprint $table) {
            if (!Schema::hasColumn('work_forms', 'go_year')) {
                $table->string('go_year', 4)->nullable()->after('from_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_forms', function (Blueprint $table) {
            //
        });
    }
};
