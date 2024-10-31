<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Tabela 'series'
     * Esta tabela armazena informações sobre as séries disponíveis na plataforma,
     * incluindo título, descrição, ano de lançamento e categoria.
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id(); // Primary ID
            $table->string('title', 1000);// Anime title
            $table->string('img_src')->nullable(); // Image URL 
            $table->string('trailer_src')->nullable(); // Image URL
            $table->decimal('score', 3, 2)->nullable(); // Anime score (max 9.99)
            $table->string('votos')->nullable(); // Number of votes
            $table->string('sub_categoria')->nullable(); // Subcategories as a string
            $table->string('temporada')->nullable(); // Season
            $table->string('estudios')->nullable(); // Production studio
            $table->string('audio')->nullable(); // Audio (e.g., Dubbed)
            $table->string('episodios')->nullable(); // Episode count (string to handle values like "??")
            $table->string('status_anime')->nullable(); // Anime status
            $table->string('dia_lancamento')->nullable(); // Release day
            $table->string('ano')->nullable(); // Release year
            $table->text('sinopse')->nullable();
            $table->timestamps(); // Created_at and updated_at fields
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('series');
    }
};
