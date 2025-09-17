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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_profile_id')->index('student_profile_id');
            $table->unsignedBigInteger('professional_id');
            $table->timestamp('scheduled_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('duration_minutes')->nullable()->default(30);
            $table->enum('status', ['pendiente', 'confirmado', 'completado', 'cancelado', 'no_asistio'])->nullable()->default('pendiente');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index('created_by');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index(['professional_id', 'scheduled_at'], 'idx_prof_sched');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
