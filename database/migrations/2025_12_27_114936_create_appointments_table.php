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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('doctor_id'); // Foreign Key to Doctors
        $table->unsignedBigInteger('patient_id'); // Foreign Key to Patients
        $table->date('appointment_date'); // Appointment Date
        $table->time('appointment_time'); // Appointment Time
        $table->text('symptoms')->nullable(); // Symptoms
        $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Completed'])->default('Pending');
        $table->timestamps();

        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
