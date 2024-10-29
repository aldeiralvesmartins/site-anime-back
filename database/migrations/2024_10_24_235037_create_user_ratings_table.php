<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela 'user_ratings'
     * Esta tabela armazena as avaliações dadas pelos usuários aos filmes e séries,
     * com uma avaliação de 1 a 5.
     */
    public function up()
    {
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_anime_id')->constrained()->onDelete('cascade'); // Relaciona com o usuário
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Relaciona com o filme ou série
            $table->integer('rating'); // Avaliação dada pelo usuário (1 a 5)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_ratings');
    }
};
