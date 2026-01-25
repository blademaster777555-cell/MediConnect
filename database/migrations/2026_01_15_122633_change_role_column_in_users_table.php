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
            // Change role to string to accept 'admin', 'doctor', 'patient'
            // modifying column requires doctrine/dbal, if not present, we might need a raw query or drop/add
            // taking a safer route for raw SQL to ensure it works without extra dependencies
            $table->string('role', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->tinyInteger('role')->default(0)->change();
        });
    }
};
