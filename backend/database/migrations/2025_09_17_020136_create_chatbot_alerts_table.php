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
        Schema::create('chatbot_alerts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chatbot_interaction_id')->index('chatbot_interaction_id');
            $table->unsignedBigInteger('student_profile_id')->nullable()->index('student_profile_id');
            $table->enum('alert_type', ['alto_estres', 'sin_reporte', 'riesgo_palabra_clave', 'solicitud_manual', 'otro']);
            $table->enum('severity', ['bajo', 'medio', 'alto', 'critico'])->default('medio');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('resolved_at')->nullable();
            $table->unsignedBigInteger('resolved_by')->nullable()->index('resolved_by');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_alerts');
    }
};
