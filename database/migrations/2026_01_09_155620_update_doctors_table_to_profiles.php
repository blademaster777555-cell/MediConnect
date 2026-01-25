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
        // TRƯỜNG HỢP 1: Đã có bảng 'doctors' -> Đổi tên thành 'doctor_profiles'
        if (Schema::hasTable('doctors') && !Schema::hasTable('doctor_profiles')) {
            Schema::rename('doctors', 'doctor_profiles');
        }

        // TRƯỜNG HỢP 2: Chưa có bảng nào cả -> Tạo mới 'doctor_profiles'
        if (!Schema::hasTable('doctor_profiles')) {
            Schema::create('doctor_profiles', function (Blueprint $table) {
                $table->id();
                // Check if users table uses bigIncrements (default) or generic id
                $table->unsignedBigInteger('user_id'); 
                $table->unsignedInteger('specialization_id')->nullable(); 
                $table->unsignedInteger('city_id')->nullable(); 
                
                $table->text('bio')->nullable();
                $table->string('phone')->nullable();
                $table->string('license_number')->nullable();
                $table->decimal('consultation_fee', 10, 2)->default(0);
                $table->timestamps();

                // Foreign Keys - Assuming users.id is bigInteger, others depend on their definition
                // Using explicit definitions to avoid mismatch errors if types differ
            });
        }

        // Bổ sung các cột còn thiếu và khóa ngoại
        Schema::table('doctor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_profiles', 'license_number')) {
                $table->string('license_number')->nullable();
            }
            if (!Schema::hasColumn('doctor_profiles', 'consultation_fee')) {
                $table->decimal('consultation_fee', 10, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('doctor_profiles')) {
            Schema::rename('doctor_profiles', 'doctors');
        }
    }
};
