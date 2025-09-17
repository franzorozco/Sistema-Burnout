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
        Schema::create('student_rotation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_profile_id')->index('student_profile_id');
            $table->unsignedBigInteger('rotation_id')->index('rotation_id');
            $table->timestamp('assigned_at')->nullable();
            $table->enum('shift_type', ['dia', 'noche', '36h', 'otro'])->nullable()->default('dia');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_rotation');
    }
};
