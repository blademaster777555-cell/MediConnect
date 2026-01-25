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
    Schema::create('doctors', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Foreign Key to users
        $table->string('full_name', 191);
        $table->unsignedInteger('specialization_id'); // Foreign Key to Specializations
        $table->unsignedInteger('city_id'); // Foreign Key to Cities
        $table->text('qualification')->nullable(); // Qualification/degree
        $table->string('phone', 20);
        $table->text('bio')->nullable(); // Introduction
        $table->timestamps();

        // Foreign Keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
