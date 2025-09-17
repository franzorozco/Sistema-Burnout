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
        Schema::create('state_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_profile_id');
            $table->timestamp('report_date')->useCurrent();
            $table->enum('mood', ['muy_bien', 'bien', 'neutral', 'mal', 'muy_mal'])->nullable();
            $table->integer('energy_level')->nullable();
            $table->decimal('sleep_hours', 4, 1)->nullable();
            $table->integer('stress_score')->nullable();
            $table->json('symptoms')->nullable();
            $table->string('location', 200)->nullable();
            $table->timestamps();

            $table->index(['student_profile_id', 'report_date'], 'idx_student_report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_reports');
    }
};
