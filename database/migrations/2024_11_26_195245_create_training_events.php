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
        Schema::create('training_events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->index();
            $table->string('slug', 40)->unique();
            $table->date('startdate')->index();
            $table->date('finishdate')->index();
            $table->foreignId('village_id')->nullable();
            $table->foreignId('subdistrict_id')->nullable();
            $table->foreignId('regency_id')->nullable();
            $table->foreignId('officer_id')->nullable();
            $table->jsonb('files')->nullable();
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
        Schema::dropIfExists('training_events');
    }
};
