<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code',50);
            $table->foreignId('created_by')->constrained(table: 'users', indexName: 'code_user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->unique(['code', 'created_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
