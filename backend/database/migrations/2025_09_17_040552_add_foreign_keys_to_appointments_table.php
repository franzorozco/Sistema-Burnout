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
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign(['student_profile_id'], 'appointments_ibfk_1')->references(['id'])->on('student_profiles')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['professional_id'], 'appointments_ibfk_2')->references(['id'])->on('professionals')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['created_by'], 'appointments_ibfk_3')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('appointments_ibfk_1');
            $table->dropForeign('appointments_ibfk_2');
            $table->dropForeign('appointments_ibfk_3');
        });
    }
};
