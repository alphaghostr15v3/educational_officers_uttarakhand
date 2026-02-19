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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('download_count')->default(0)->after('is_published');
        });

        Schema::table('circulars', function (Blueprint $table) {
            $table->unsignedBigInteger('download_count')->default(0)->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('download_count');
        });

        Schema::table('circulars', function (Blueprint $table) {
            $table->dropColumn('download_count');
        });
    }
};
