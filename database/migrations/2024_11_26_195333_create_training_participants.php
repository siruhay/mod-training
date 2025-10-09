<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->index();
            $table->string('slug', 40)->unique();
            $table->enum('mode', ['LKD', 'DESA'])->index()->default('LKD');
            $table->foreignId('biodata_id');
            $table->foreignId('event_id');
            $table->timestamp('accepted_at')->nullable();
            $table->jsonb('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['biodata_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participants');
    }
};
