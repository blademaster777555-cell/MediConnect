<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('doctor_availabilities', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('doctor_id'); // Foreign Key to Doctors
        $table->enum('day_of_week', ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']); // Day of week
        $table->time('start_time'); // Start time
        $table->time('end_time'); // End time
        $table->tinyInteger('is_available')->default(1); // 1: Available, 0: Not available
        $table->timestamps();

        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_availabilities');
    }
};
