<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Tabela 'ads'
     * Esta tabela armazena os anúncios que podem ser exibidos durante a reprodução de vídeos.
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título do anúncio
            $table->string('video_url'); // URL do vídeo do anúncio
            $table->integer('duration'); // Duração do anúncio em segundos
            $table->string('target_url')->nullable(); // URL de redirecionamento ao clicar no anúncio
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads');
    }
};
