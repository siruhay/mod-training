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
        Schema::create('training_questions', function (Blueprint $table) {
            $table->id();
            $table->text('name')->index();
            $table->string('slug', 40)->unique();
            $table->foreignId('event_id');
            $table->enum('mode', ['PRETEST', 'POSTEST'])->index()->default('');
            $table->jsonb('options');
            $table->string('answerkey', 1)->index()->default('A');
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
        Schema::dropIfExists('training_questions');
    }
};
