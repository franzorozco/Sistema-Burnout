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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign(['post_id'], 'comments_ibfk_1')->references(['id'])->on('posts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['user_id'], 'comments_ibfk_2')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['parent_comment_id'], 'comments_ibfk_3')->references(['id'])->on('comments')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_ibfk_1');
            $table->dropForeign('comments_ibfk_2');
            $table->dropForeign('comments_ibfk_3');
        });
    }
};
