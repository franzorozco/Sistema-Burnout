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
        Schema::table('chatbot_interactions', function (Blueprint $table) {
            $table->foreign(['user_id'], 'chatbot_interactions_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chatbot_interactions', function (Blueprint $table) {
            $table->dropForeign('chatbot_interactions_ibfk_1');
        });
    }
};
