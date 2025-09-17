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
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->enum('type', ['articulo', 'video', 'ejercicio', 'pdf', 'enlace', 'otro'])->nullable()->default('articulo');
            $table->text('summary')->nullable();
            $table->text('content')->nullable();
            $table->string('url', 1024)->nullable();
            $table->unsignedBigInteger('author_id')->nullable()->index('author_id');
            $table->unsignedBigInteger('validated_by')->nullable()->index('validated_by');
            $table->timestamp('validated_at')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
