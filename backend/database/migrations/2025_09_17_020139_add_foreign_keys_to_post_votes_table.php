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
        Schema::table('post_votes', function (Blueprint $table) {
            $table->foreign(['user_id'], 'post_votes_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['post_id'], 'post_votes_ibfk_2')->references(['id'])->on('posts')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['comment_id'], 'post_votes_ibfk_3')->references(['id'])->on('comments')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_votes', function (Blueprint $table) {
            $table->dropForeign('post_votes_ibfk_1');
            $table->dropForeign('post_votes_ibfk_2');
            $table->dropForeign('post_votes_ibfk_3');
        });
    }
};
