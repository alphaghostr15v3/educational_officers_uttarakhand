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
            $table->string('promotion_order_number')->nullable()->after('title');
            $table->date('promotion_order_date')->nullable()->after('promotion_order_number');
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
