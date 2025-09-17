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
        Schema::create('chatbot_interactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->string('session_id', 191)->nullable()->index('idx_session');
            $table->text('input_text')->nullable();
            $table->json('input_metadata')->nullable();
            $table->text('response_text')->nullable();
            $table->json('response_metadata')->nullable();
            $table->string('intent', 200)->nullable();
            $table->json('sentiment')->nullable();
            $table->boolean('detected_risk')->nullable()->default(false);
            $table->json('detected_keywords')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_interactions');
    }
};
