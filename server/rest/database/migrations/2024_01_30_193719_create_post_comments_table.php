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
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->binary("description");
            // render blob with the same method like kaizen klass
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("post_id");
            $table->boolean("is_honey_pot")->default(false);
            $table->uuid("post_comment_uuid")->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
