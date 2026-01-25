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
    // Kiểm tra nếu bảng chưa có thì mới tạo
    if (!Schema::hasTable('medical_content')) {
        Schema::create('medical_content', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề
            $table->text('content'); // Nội dung
            $table->string('category')->default('news'); // <--- QUAN TRỌNG: Phải đặt là 'category'
            $table->string('image')->nullable(); // Ảnh
            $table->foreignId('author_id')->nullable()->constrained('users'); // Người đăng
            $table->timestamp('published_date')->nullable();
            $table->timestamps();
        });
    }
    }

    public function down()
    {
    Schema::dropIfExists('medical_content');
    }
};
