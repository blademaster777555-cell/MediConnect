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
        Schema::table('doctor_profiles', function (Blueprint $table) {
            // Drop foreign key if it exists. constraint name found in error trace.
            // Check if foreign key exists first to avoid error on retry
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'doctor_profiles' 
                 AND COLUMN_NAME = 'specialization_id'"
            );

            if (!empty($foreignKeys)) {
                $table->dropForeign($foreignKeys[0]->CONSTRAINT_NAME);
            }
            
            $table->unsignedBigInteger('specialization_id')->nullable()->change();
            
            // Re-add foreign key
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
             // Drop current foreign key
             $table->dropForeign(['specialization_id']);
             
             $table->unsignedBigInteger('specialization_id')->nullable(false)->change();
             
             $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }
};
