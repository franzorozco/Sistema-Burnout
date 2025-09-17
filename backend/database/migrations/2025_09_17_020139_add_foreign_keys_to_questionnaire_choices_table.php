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
        Schema::table('questionnaire_choices', function (Blueprint $table) {
            $table->foreign(['item_id'], 'questionnaire_choices_ibfk_1')->references(['id'])->on('questionnaire_items')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_choices', function (Blueprint $table) {
            $table->dropForeign('questionnaire_choices_ibfk_1');
        });
    }
};
