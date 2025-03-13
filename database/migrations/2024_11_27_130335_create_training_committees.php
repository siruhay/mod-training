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
        Schema::create('training_committees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->index();
            $table->string('slug', 18)->index();
            $table->enum('type', ['MODERATOR', 'FELLOW', 'SPEAKER'])->index()->default('FELLOW');
            $table->foreignId('biodata_id');
            $table->foreignId('event_id');
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
        Schema::dropIfExists('training_committees');
    }
};
