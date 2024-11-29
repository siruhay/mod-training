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
        Schema::create('training_rundowns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->index();
            $table->string('slug', 40)->unique();
            $table->foreignId('event_id')->nullable();
            $table->date('datemark')->index();
            $table->time('starttime')->index();
            $table->time('finishtime')->index();
            $table->text('agenda');
            $table->foreignId('speaker_id')->nullable();
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
        Schema::dropIfExists('training_rundowns');
    }
};
