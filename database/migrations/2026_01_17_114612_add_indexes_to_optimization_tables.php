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
            $table->index('specialization_id');
            $table->index('user_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->index('date');
            $table->index('status');
            $table->index(['patient_id', 'status']); // Compound index for dashboard queries
            $table->index(['doctor_id', 'status']);  // Compound index for doctor dashboard
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('city_id');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_profiles', function (Blueprint $table) {
            $table->dropIndex(['specialization_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['patient_id', 'status']);
            $table->dropIndex(['doctor_id', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['city_id']);
            $table->dropIndex(['role']);
        });
    }
};
