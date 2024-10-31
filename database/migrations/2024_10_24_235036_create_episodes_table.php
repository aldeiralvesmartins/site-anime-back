<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Tabela 'episodes'
     * Esta tabela armazena os episódios de cada série. Cada episódio é vinculado a uma série e
     * contém informações sobre a temporada e número do episódio.
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título do episódio
            $table->integer('episode_number'); // Número do episódio dentro da temporada
            $table->foreignId('series_id')->constrained()->onDelete('cascade'); 
            $table->string('url_image'); // Título do episódio
            $table->text('url_video'); // Título do episódio
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('episodes');
    }
};
