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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['state_admin', 'division_admin', 'district_admin', 'officer'])->default('officer')->after('password');
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('set null')->after('role');
            $table->foreignId('district_id')->nullable()->constrained()->onDelete('set null')->after('division_id');
            $table->string('employee_code')->unique()->nullable()->after('district_id');
            $table->string('mobile')->nullable()->after('employee_code');
            $table->boolean('is_active')->default(true)->after('mobile');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['division_id']);
            $table->dropForeign(['district_id']);
            $table->dropColumn(['role', 'division_id', 'district_id', 'employee_code', 'mobile', 'is_active', 'last_login_at']);
        });
    }
};
