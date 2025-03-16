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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'title');
            $table->string(column:'content');
            $table->string(column:'imageUrl');
            // Création d'une clé étrangère user_id pour la liaison entre les deux tables
            // 'foreignId' crée une colonne user_id qui fera référence à la colonne id de la table users.
            // constrained crée une contrainte de clé étrangère, liant user_id à id dans la table users.
            // onDelete('cascade') spécifie que si un utilisateur est supprimé, tous ses posts associés seront également supprimés.
            $table->foreignId(column:'user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
