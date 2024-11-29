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
        Schema::create('training_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('participant_id');
            $table->foreignId('question_id');
            $table->string('answer', 1)->index()->default('A');
            $table->boolean('is_correct')->default(false);
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
        Schema::dropIfExists('training_answers');
    }
};
