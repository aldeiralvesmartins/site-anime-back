<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Tabela 'user_episode_progress'
     * Esta tabela armazena o progresso de um usuário em cada episódio de uma série,
     * permitindo registrar o tempo em que ele parou de assistir.
     */
    public function up()
    {
        Schema::create('user_episode_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_anime_id')->constrained()->onDelete('cascade'); // Relaciona com o usuário
            $table->foreignId('episode_id')->constrained()->onDelete('cascade'); // Relaciona com o episódio da série
            $table->integer('watched_duration')->default(0); // Duração assistida em minutos ou segundos (dependendo da implementação)
            $table->boolean('is_finished')->default(false); // Indica se o episódio foi concluído
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_episode_progress');
    }
};
