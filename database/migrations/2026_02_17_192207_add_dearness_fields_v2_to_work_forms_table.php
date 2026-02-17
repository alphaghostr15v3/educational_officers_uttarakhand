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
            if (!Schema::hasColumn('work_forms', 'dearness_percentage')) {
                $table->decimal('dearness_percentage', 5, 2)->nullable()->after('promotion_order_date');
            }
            if (!Schema::hasColumn('work_forms', 'from_date')) {
                $table->date('from_date')->nullable()->after('dearness_percentage');
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
