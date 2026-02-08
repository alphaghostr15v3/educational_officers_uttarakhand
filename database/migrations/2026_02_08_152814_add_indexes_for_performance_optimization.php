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
        Schema::table('employee_birthdays', function (Blueprint $table) {
            $table->index('dob');
            $table->index('is_active');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('is_published');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index('is_published');
            $table->index('is_ticker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_birthdays', function (Blueprint $table) {
            $table->dropIndex(['dob']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['is_ticker']);
        });
    }
};
