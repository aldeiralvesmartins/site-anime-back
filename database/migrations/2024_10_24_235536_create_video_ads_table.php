<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Tabela 'video_ads'
     * Esta tabela relaciona anúncios com vídeos (filmes ou episódios),
     * permitindo que múltiplos anúncios sejam exibidos em diferentes pontos de um vídeo.
     */
    public function up()
    {
        Schema::create('video_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_id')->constrained('ads')->onDelete('cascade'); // Relaciona com a tabela de anúncios
            $table->foreignId('movie_id')->nullable()->constrained()->onDelete('cascade'); // Relaciona com filmes
            $table->foreignId('episode_id')->nullable()->constrained()->onDelete('cascade'); // Relaciona com episódios de série
            $table->integer('display_time'); // Momento em que o anúncio será exibido no vídeo (em segundos)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_ads');
    }
};
