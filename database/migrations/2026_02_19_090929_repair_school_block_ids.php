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
        $schools = \Illuminate\Support\Facades\DB::table('schools')->get();
        
        foreach ($schools as $school) {
            if ($school->block) {
                $block = \Illuminate\Support\Facades\DB::table('blocks')
                    ->where('name', 'LIKE', '%' . $school->block . '%')
                    ->orWhere('name', $school->block)
                    ->first();
                    
                if ($block) {
                    \Illuminate\Support\Facades\DB::table('schools')
                        ->where('id', $school->id)
                        ->update(['block_id' => $block->id]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            //
        });
    }
};
