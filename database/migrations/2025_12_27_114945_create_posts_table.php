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
    Schema::create('medical_content', function (Blueprint $table) {
        $table->id();
        $table->string('title', 255); // Content title
        $table->string('category', 100); // Category
        $table->longText('content'); // Content
        $table->unsignedBigInteger('author_id')->nullable(); // Foreign Key to Users (Admin)
        $table->dateTime('published_date')->nullable(); // Published date
        $table->timestamps();

        $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_content');
    }
};
