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
        Schema::table('questionnaire_items', function (Blueprint $table) {
            $table->foreign(['questionnaire_id'], 'questionnaire_items_ibfk_1')->references(['id'])->on('questionnaires')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_items', function (Blueprint $table) {
            $table->dropForeign('questionnaire_items_ibfk_1');
        });
    }
};
