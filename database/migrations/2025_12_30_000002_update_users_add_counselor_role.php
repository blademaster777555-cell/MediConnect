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
            // Cập nhật comment cho cột role
            // 1=Admin, 2=Doctor, 3=Patient, 4=Counselor
            $table->tinyInteger('role')->default(3)->comment('1=Admin, 2=Doctor, 3=Patient, 4=Counselor')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role')->default(3)->comment('1=Admin, 2=Doctor, 3=Patient')->change();
        });
    }
};