<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabela 'categories'
     * Esta tabela armazena as diferentes categorias de filmes e séries (ex: Ação, Comédia, Drama),
     * que são usadas para organizar os conteúdos na plataforma.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome da categoria (ex: Ação, Comédia)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
