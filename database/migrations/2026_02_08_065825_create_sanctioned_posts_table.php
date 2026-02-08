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
        Schema::create('sanctioned_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('designation_id')->constrained()->cascadeOnDelete();
            $table->enum('level', ['state', 'division', 'district', 'school']);
            $table->foreignId('school_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('sanctioned_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanctioned_posts');
    }
};
