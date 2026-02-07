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
        Schema::create('student_strengths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('class_group'); // e.g., Class 1-5, Class 6-8, Class 9-10, Class 11-12
            $table->string('stream')->nullable(); // Arts, Science, Commerce (useful for 11-12)
            $table->integer('boys')->default(0);
            $table->integer('girls')->default(0);
            $table->integer('total')->default(0); // Calculated or stored
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_strengths');
    }
};
