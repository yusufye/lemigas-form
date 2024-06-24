<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Code;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('public_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_id')->constrained(table: 'codes', indexName: 'form_code_id')->onUpdate('cascade')->onDelete('cascade')->unique();
            $table->enum('kepentingan_1', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_2', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_3', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_4', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_5', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_6', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_7', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_8', [1,2,3,4])->nullable(false);
            $table->enum('kepentingan_9', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_1', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_2', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_3', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_4', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_5', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_6', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_7', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_8', [1,2,3,4])->nullable(false);
            $table->enum('kepuasan_9', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_1', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_2', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_3', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_4', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_5', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_6', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_7', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_8', [1,2,3,4])->nullable(false);
            $table->enum('korupsi_9', [1,2,3,4])->nullable(false);
            $table->string('company_name',100)->nullable(true);
            $table->string('company_address',500)->nullable(true);
            $table->string('company_phone',100)->nullable(true);
            $table->string('signature_path',200)->nullable(true);
            $table->text('remark')->nullable(true);
            $table->timestamp('submitted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_forms');
    }
};
