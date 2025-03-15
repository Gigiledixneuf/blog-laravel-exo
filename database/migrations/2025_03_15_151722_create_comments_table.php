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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            //liason a la table users par son id
            $table->foreignId(column:'user_id')->constrained('users')->onDelete('cascade');
            //liason a la table posts par son id
            $table->foreignId(column:'post_id')->constrained('posts')->onDelete('cascade');
            $table->text(column:'comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
