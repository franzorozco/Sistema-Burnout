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
        Schema::create('questionnaire_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('questionnaire_id')->index('questionnaire_id');
            $table->unsignedBigInteger('student_profile_id')->nullable()->index('student_profile_id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->timestamp('submitted_at')->nullable()->useCurrent();
            $table->double('summary_score')->nullable();
            $table->json('raw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_responses');
    }
};
