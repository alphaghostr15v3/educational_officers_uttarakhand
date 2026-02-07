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
        Schema::create('school_infrastructures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->integer('classrooms')->default(0);
            $table->integer('toilets_boys')->default(0);
            $table->integer('toilets_girls')->default(0);
            $table->boolean('drinking_water')->default(false);
            $table->boolean('electricity')->default(false);
            $table->integer('computers')->default(0);
            $table->boolean('library')->default(false);
            $table->boolean('playground')->default(false);
            $table->boolean('smart_class')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_infrastructures');
    }
};
