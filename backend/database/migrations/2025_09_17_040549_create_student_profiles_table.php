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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique('user_id');
            $table->string('student_code', 50)->nullable()->unique('student_code');
            $table->date('birthdate')->nullable();
            $table->string('career', 100)->nullable();
            $table->integer('semester')->nullable();
            $table->string('group_name', 100)->nullable();
            $table->boolean('consent_given')->default(false);
            $table->timestamp('consent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
