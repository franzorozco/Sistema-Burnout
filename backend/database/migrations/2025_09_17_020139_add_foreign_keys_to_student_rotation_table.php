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
        Schema::table('student_rotation', function (Blueprint $table) {
            $table->foreign(['student_profile_id'], 'student_rotation_ibfk_1')->references(['id'])->on('student_profiles')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['rotation_id'], 'student_rotation_ibfk_2')->references(['id'])->on('rotations')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_rotation', function (Blueprint $table) {
            $table->dropForeign('student_rotation_ibfk_1');
            $table->dropForeign('student_rotation_ibfk_2');
        });
    }
};
