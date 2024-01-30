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
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->id();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("post_comment_id")->references("id")->on("post_comments")->onDelete("cascade");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("post_comment_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_likes');
    }
};
