<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela 'movies'
     * Esta tabela armazena informações sobre os filmes disponíveis na plataforma,
     * incluindo título, descrição, ano de lançamento, duração e categoria.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título do filme
            $table->text('description')->nullable(); // Descrição do filme
            $table->integer('release_year')->nullable(); // Ano de lançamento do filme
            $table->decimal('rating', 3, 1)->nullable(); // Avaliação média do filme
            $table->integer('duration')->nullable(); // Duração do filme em minutos
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Categoria relacionada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
