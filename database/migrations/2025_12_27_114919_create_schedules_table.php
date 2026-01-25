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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('doctor_id');
        
        $table->date('available_date'); // Ngày làm việc (VD: 2025-10-20)
        $table->time('start_time');     // Giờ bắt đầu (08:00)
        $table->time('end_time');       // Giờ kết thúc (17:00)
        
        // Trạng thái: active (đang mở), inactive (bác sĩ nghỉ đột xuất)
        $table->string('status')->default('active'); 
        
        $table->timestamps();
        
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
