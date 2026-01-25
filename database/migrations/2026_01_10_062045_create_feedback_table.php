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
        if (!Schema::hasTable('feedbacks')) {
            Schema::create('feedbacks', function (Blueprint $table) {
                $table->id();
                // Liên kết với Lịch hẹn (Mỗi cuộc hẹn 1 đánh giá)
                $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
                
                // Điểm đánh giá (1 đến 5 sao)
                $table->integer('rating')->default(5);
                
                // Nội dung bình luận
                $table->text('comment')->nullable();
                
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
