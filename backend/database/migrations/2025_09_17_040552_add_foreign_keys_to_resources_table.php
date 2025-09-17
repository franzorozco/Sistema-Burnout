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
        Schema::table('resources', function (Blueprint $table) {
            $table->foreign(['author_id'], 'resources_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['validated_by'], 'resources_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropForeign('resources_ibfk_1');
            $table->dropForeign('resources_ibfk_2');
        });
    }
};
