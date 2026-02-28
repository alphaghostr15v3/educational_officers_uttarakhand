<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new column
        Schema::table('users', function (Blueprint $table) {
            $table->string('new_role')->default('officer')->after('password');
        });

        // Copy data
        DB::table('users')->update([
            'new_role' => DB::raw('role')
        ]);

        // Drop old column and rename new one
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('new_role', 'role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('old_role')->default('officer')->after('password');
        });

        DB::table('users')->update([
            'old_role' => DB::raw('role')
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('old_role', 'role');
        });
    }
};
