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
        Schema::create('training_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug', 18)->unique();
            $table->enum('role', ['ADMIN', 'KADIS'])->index()->default('ADMIN');
            $table->jsonb('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_settings');
    }
};
