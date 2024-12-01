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
        Schema::create('code_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('code_id'); // Relasi ke tabel codes
            $table->string('file_path');          // Path file yang disimpan
            $table->timestamps();
        
            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_files');
    }
};
