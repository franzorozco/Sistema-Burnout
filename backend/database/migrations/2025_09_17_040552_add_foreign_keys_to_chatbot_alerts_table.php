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
        Schema::table('chatbot_alerts', function (Blueprint $table) {
            $table->foreign(['chatbot_interaction_id'], 'chatbot_alerts_ibfk_1')->references(['id'])->on('chatbot_interactions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['student_profile_id'], 'chatbot_alerts_ibfk_2')->references(['id'])->on('student_profiles')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['resolved_by'], 'chatbot_alerts_ibfk_3')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chatbot_alerts', function (Blueprint $table) {
            $table->dropForeign('chatbot_alerts_ibfk_1');
            $table->dropForeign('chatbot_alerts_ibfk_2');
            $table->dropForeign('chatbot_alerts_ibfk_3');
        });
    }
};
