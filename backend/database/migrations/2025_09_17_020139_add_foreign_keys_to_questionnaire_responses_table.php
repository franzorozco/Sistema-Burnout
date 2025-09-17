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
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->foreign(['questionnaire_id'], 'questionnaire_responses_ibfk_1')->references(['id'])->on('questionnaires')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['student_profile_id'], 'questionnaire_responses_ibfk_2')->references(['id'])->on('student_profiles')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['user_id'], 'questionnaire_responses_ibfk_3')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_responses', function (Blueprint $table) {
            $table->dropForeign('questionnaire_responses_ibfk_1');
            $table->dropForeign('questionnaire_responses_ibfk_2');
            $table->dropForeign('questionnaire_responses_ibfk_3');
        });
    }
};
