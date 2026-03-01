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
        Schema::table('anshandans', function (Blueprint $table) {
            $table->string('school_office')->nullable()->after('member_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anshandans', function (Blueprint $table) {
            $table->dropColumn('school_office');
        });
    }
};
